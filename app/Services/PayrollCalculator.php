<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Timesheet;
use Carbon\Carbon;
use DateTime;
use Exception;

class PayrollCalculator
{
    /**
     * Calculate payroll dataset for employees in a given period.
     *
     * @param int|string $year
     * @param int|string $month
     * @param string $cutoff ('1-15' or '16-30')
     * @param int|string|null $employeeId
     * @return array
     */
    public function calculate(int|string $year, int|string $month, string $cutoff = '1-15', int|string|null $employeeId = null): array
    {
        $year = (int)$year;
        $month = (int)$month;

        if ($cutoff === '1-15') {
            $startDate = sprintf('%04d-%02d-01', $year, $month);
            $endDate = sprintf('%04d-%02d-15', $year, $month);
        } else {
            $startDate = sprintf('%04d-%02d-16', $year, $month);
            $lastDay = Carbon::createFromDate($year, $month, 1)->endOfMonth()->day;
            $endDate = sprintf('%04d-%02d-%02d', $year, $month, $lastDay);
        }

        // Generate all dates in period
        $periodDates = [];
        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($current->lte($end)) {
            $periodDates[] = $current->format('Y-m-d');
            $current->addDay();
        }

        // Fetch employees
        $query = Employee::with('position');
        if (!empty($employeeId)) {
            $query->where('id', $employeeId);
        }
        $employees = $query->orderBy('last_name')->orderBy('first_name')->get();

        // Fetch timesheets in date range
        $timesheets = Timesheet::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy(fn ($ts) => $ts->employee_id . '_' . Carbon::parse($ts->date)->format('Y-m-d'));

        $results = [];

        foreach ($employees as $employee) {
            $empData = [
                'id' => $employee->id,
                'employee_name' => $employee->first_name . ' ' . $employee->last_name,
                'position_name' => $employee->position?->name ?? 'Unassigned',
                'base_rate' => (float)($employee->position?->base_rate ?? 0),
                'overtime_rate' => (float)($employee->position?->overtime_rate ?? 0),
                'sss' => (float)($employee->position?->sss ?? 0),
                'philhealth' => (float)($employee->position?->philhealth ?? 0),
                'pag_ibig' => (float)($employee->position?->pag_ibig ?? 0),
                'days' => [],
                'total_regular_hours' => 0.0,
                'total_ot_hours' => 0.0,
                'total_regular_pay' => 0.0,
                'total_ot_pay' => 0.0,
                'total_allowance' => 0.0,
                'total_extra_income' => 0.0,
                'total_deductions' => 0.0,
                'gross_pay' => 0.0,
                'total_govt_deductions' => 0.0,
                'net_pay' => 0.0,
            ];

            foreach ($periodDates as $dateStr) {
                $key = $employee->id . '_' . $dateStr;
                $timesheet = $timesheets->get($key)?->first();

                $dayResult = $this->calculateDay($dateStr, $timesheet, $empData['base_rate'], $empData['overtime_rate']);

                $empData['days'][] = $dayResult;

                // Accumulate totals
                $empData['total_regular_hours'] += $dayResult['regular_hours'];
                $empData['total_ot_hours'] += $dayResult['ot_hours'];
                $empData['total_regular_pay'] += $dayResult['regular_pay'];
                $empData['total_ot_pay'] += $dayResult['ot_pay'];
                $empData['total_allowance'] += $dayResult['allowance'];
                $empData['total_extra_income'] += $dayResult['extra_income'];
                $empData['total_deductions'] += $dayResult['deduction'];
            }

            // Round accumulated values
            $empData['total_regular_hours'] = round($empData['total_regular_hours'], 2);
            $empData['total_ot_hours'] = round($empData['total_ot_hours'], 2);
            $empData['total_regular_pay'] = round($empData['total_regular_pay'], 2);
            $empData['total_ot_pay'] = round($empData['total_ot_pay'], 2);
            $empData['total_allowance'] = round($empData['total_allowance'], 2);
            $empData['total_extra_income'] = round($empData['total_extra_income'], 2);
            $empData['total_deductions'] = round($empData['total_deductions'], 2);

            $empData['gross_pay'] = round(
                $empData['total_regular_pay'] +
                $empData['total_ot_pay'] +
                $empData['total_allowance'] +
                $empData['total_extra_income'],
                2
            );

            $empData['total_govt_deductions'] = round(
                $empData['sss'] + $empData['philhealth'] + $empData['pag_ibig'],
                2
            );

            $empData['net_pay'] = round(
                $empData['gross_pay'] - ($empData['total_govt_deductions'] + $empData['total_deductions']),
                2
            );

            $results[] = $empData;
        }

        return [
            'year' => $year,
            'month' => $month,
            'cutoff' => $cutoff,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'employees' => $results,
            'grand_summary' => [
                'total_employees' => count($results),
                'total_net_payable' => round(array_sum(array_column($results, 'net_pay')), 2),
                'total_gross_pay' => round(array_sum(array_column($results, 'gross_pay')), 2),
                'total_regular_hours' => round(array_sum(array_column($results, 'total_regular_hours')), 2),
                'total_ot_hours' => round(array_sum(array_column($results, 'total_ot_hours')), 2),
            ]
        ];
    }

    /**
     * Calculate single day attendance and pay metrics.
     */
    protected function calculateDay(string $dateStr, ?Timesheet $timesheet, float $baseRate, float $otRate): array
    {
        $default = [
            'date' => $dateStr,
            'has_record' => !is_null($timesheet),
            'time_in' => $timesheet?->time_in,
            'time_out' => $timesheet?->time_out,
            'is_on_leave' => (bool)($timesheet?->is_on_leave ?? false),
            'is_absent' => false,
            'time_adjusted' => false,
            'is_late' => false,
            'gross_hours' => 0.0,
            'net_hours' => 0.0,
            'regular_hours' => 0.0,
            'ot_hours' => 0.0,
            'lunch_break' => 0.0,
            'dinner_break' => 0.0,
            'total_breaks' => 0.0,
            'regular_pay' => 0.0,
            'ot_pay' => 0.0,
            'allowance' => 0.0,
            'extra_income' => (float)($timesheet?->extra_income ?? 0.0),
            'extra_income_description' => $timesheet?->extra_income_description,
            'deduction' => (float)($timesheet?->deduction ?? 0.0),
            'deduction_description' => $timesheet?->deduction_description,
            'day_total' => 0.0,
        ];

        if (!$timesheet || $timesheet->is_on_leave || !$timesheet->time_in || !$timesheet->time_out) {
            if ($timesheet && !$timesheet->is_on_leave && (!$timesheet->time_in || !$timesheet->time_out)) {
                $default['is_absent'] = true;
            }
            return $default;
        }

        $timeInObj = $this->createTimeWithoutSeconds($dateStr . ' ' . $timesheet->time_in);
        $timeOutObj = $this->createTimeWithoutSeconds($dateStr . ' ' . $timesheet->time_out);

        if (!$timeInObj || !$timeOutObj) {
            return $default;
        }

        $originalTimeIn = clone $timeInObj;

        // Check midday adjustment: 11:00 AM to 12:59 PM adjusts to 01:00 PM
        $elevenAM = $this->createTimeWithoutSeconds($dateStr . ' 11:00:00');
        $onePM = $this->createTimeWithoutSeconds($dateStr . ' 13:00:00');
        $timeAdjusted = false;

        if ($timeInObj >= $elevenAM && $timeInObj < $onePM) {
            $timeInObj = clone $onePM;
            $timeAdjusted = true;
        }

        // Early timeout adjustment: 5:30 PM to 5:59 PM saves as 5:30 PM
        $fiveThirtyPM = $this->createTimeWithoutSeconds($dateStr . ' 17:30:00');
        $sixPM = $this->createTimeWithoutSeconds($dateStr . ' 18:00:00');
        $tenPM = $this->createTimeWithoutSeconds($dateStr . ' 22:00:00');

        if ($timeOutObj >= $fiveThirtyPM && $timeOutObj < $sixPM) {
            $timeOutObj = clone $fiveThirtyPM;
        }

        // Calculate Gross Hours
        $grossTotalHours = $this->calculateRoundedHours($timeInObj, $timeOutObj);

        // Break Calculations
        $lunchBreak = 0.0;
        $dinnerBreak = 0.0;

        if ($timeInObj < $onePM && $grossTotalHours > 5.0) {
            $lunchBreak = 1.0;
        }

        if ($timeOutObj > $tenPM) {
            $dinnerBreak = 1.0;
        }

        $totalBreaks = $lunchBreak + $dinnerBreak;
        $netTotalHours = round(max(0.0, $grossTotalHours - $totalBreaks), 2);

        // Regular & OT Calculation
        $shiftStart = $this->createTimeWithoutSeconds($dateStr . ' 08:30:00');
        $regularHours = 0.0;
        $otHours = 0.0;

        if ($timeOutObj > $shiftStart) {
            $workStart = max($timeInObj, $shiftStart);
            $workEnd = min($timeOutObj, $fiveThirtyPM);

            if ($workEnd > $workStart) {
                $regularHours = $this->calculateRoundedHours($workStart, $workEnd);

                if ($lunchBreak > 0 && $regularHours > 0) {
                    $regularHours = max(0.0, $regularHours - $lunchBreak);
                }

                $regularHours = min(8.0, $regularHours);
            }
        }

        if ($timeOutObj > $fiveThirtyPM) {
            $otHours = $this->calculateRoundedHours($fiveThirtyPM, $timeOutObj);

            if ($dinnerBreak > 0 && $otHours > 0) {
                $otHours = max(0.0, $otHours - $dinnerBreak);
            }
        }

        // Rule 1: Cap regular at 8
        if ($regularHours > 8.0) {
            $otHours += ($regularHours - 8.0);
            $regularHours = 8.0;
        }

        // Rule 2: Shift OT into regular up to 8
        if ($regularHours < 8.0 && $otHours > 0) {
            $needed = 8.0 - $regularHours;
            $transfer = min($needed, $otHours);
            $regularHours += $transfer;
            $otHours -= $transfer;
        }

        // Rule 3: Ensure total hours <= net hours
        if ($regularHours + $otHours > $netTotalHours) {
            $excess = ($regularHours + $otHours) - $netTotalHours;
            if ($otHours >= $excess) {
                $otHours -= $excess;
            } else {
                $regularHours -= $excess;
            }
        }

        $regularHours = round($regularHours, 2);
        $otHours = round($otHours, 2);

        // Late Check: after 08:45 AM
        $lateThreshold = $this->createTimeWithoutSeconds($dateStr . ' 08:45:00');
        $isLate = (!$timeAdjusted && $originalTimeIn > $lateThreshold);

        // Calculate Pay
        $regularPay = round(($regularHours / 8.0) * $baseRate, 2);
        $otPay = round($otHours * $otRate, 2);
        $allowance = $timesheet->has_meal_allowance ? 50.0 : 0.0;
        $extraIncome = (float)($timesheet->extra_income ?? 0.0);
        $deduction = (float)($timesheet->deduction ?? 0.0);

        $dayTotal = round($regularPay + $otPay + $allowance + $extraIncome - $deduction, 2);

        return [
            'date' => $dateStr,
            'has_record' => true,
            'time_in' => $timesheet->time_in,
            'time_out' => $timesheet->time_out,
            'is_on_leave' => (bool)$timesheet->is_on_leave,
            'is_absent' => false,
            'time_adjusted' => $timeAdjusted,
            'is_late' => $isLate,
            'gross_hours' => round($grossTotalHours, 2),
            'net_hours' => round($netTotalHours, 2),
            'regular_hours' => round($regularHours, 2),
            'ot_hours' => round($otHours, 2),
            'lunch_break' => $lunchBreak,
            'dinner_break' => $dinnerBreak,
            'total_breaks' => $totalBreaks,
            'regular_pay' => $regularPay,
            'ot_pay' => $otPay,
            'allowance' => $allowance,
            'extra_income' => $extraIncome,
            'extra_income_description' => $timesheet->extra_income_description,
            'deduction' => $deduction,
            'deduction_description' => $timesheet->deduction_description,
            'day_total' => $dayTotal,
        ];
    }

    protected function createTimeWithoutSeconds(string $timeString): ?DateTime
    {
        try {
            $time = new DateTime($timeString);
            return new DateTime($time->format('Y-m-d H:i:00'));
        } catch (Exception) {
            return null;
        }
    }

    protected function calculateRoundedHours(DateTime $timeIn, DateTime $timeOut): float
    {
        $startMinutes = ((int)$timeIn->format('H') * 60) + (int)$timeIn->format('i');
        $endMinutes = ((int)$timeOut->format('H') * 60) + (int)$timeOut->format('i');

        $totalMinutes = $endMinutes - $startMinutes;
        return max(0.0, round($totalMinutes / 60, 2));
    }
}
