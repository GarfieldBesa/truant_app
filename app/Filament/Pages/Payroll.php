<?php

namespace App\Filament\Pages;

use App\Models\Employee;
use App\Services\PayrollCalculator;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Payroll extends Page
{
    protected static \UnitEnum|string|null $navigationGroup = 'Compensations and Benefits';

    protected static ?string $navigationLabel = 'Payroll';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected string $view = 'filament.pages.payroll';

    public int $selectedYear = 2026;
    public int $selectedMonth = 9;
    public string $selectedCutoff = '1-15';
    public ?string $selectedEmployeeId = null;
    public string $searchQuery = '';

    public function mount(): void
    {
        $this->selectedYear = (int)date('Y');
        $this->selectedMonth = (int)date('n');
    }

    public function getViewData(): array

    {
        $calculator = new PayrollCalculator();
        $payrollData = $calculator->calculate(
            $this->selectedYear,
            $this->selectedMonth,
            $this->selectedCutoff,
            $this->selectedEmployeeId
        );

        // Filter employees by search query if present
        if (!empty($this->searchQuery)) {
            $query = strtolower(trim($this->searchQuery));
            $payrollData['employees'] = array_values(array_filter(
                $payrollData['employees'],
                fn ($emp) => str_contains(strtolower($emp['employee_name']), $query) ||
                             str_contains(strtolower($emp['position_name']), $query) ||
                             str_contains((string)$emp['id'], $query)
            ));

            // Recalculate summary metrics for filtered results
            $payrollData['grand_summary'] = [
                'total_employees' => count($payrollData['employees']),
                'total_net_payable' => round(array_sum(array_column($payrollData['employees'], 'net_pay')), 2),
                'total_gross_pay' => round(array_sum(array_column($payrollData['employees'], 'gross_pay')), 2),
                'total_regular_hours' => round(array_sum(array_column($payrollData['employees'], 'total_regular_hours')), 2),
                'total_ot_hours' => round(array_sum(array_column($payrollData['employees'], 'total_ot_hours')), 2),
            ];
        }

        $allEmployees = Employee::orderBy('last_name')->orderBy('first_name')->get(['id', 'first_name', 'last_name']);

        return [
            'payrollData' => $payrollData,
            'allEmployees' => $allEmployees,
            'selectedCutoff' => $this->selectedCutoff,
            'selectedYear' => $this->selectedYear,
            'selectedMonth' => $this->selectedMonth,
            'selectedEmployeeId' => $this->selectedEmployeeId,
            'searchQuery' => $this->searchQuery,
            'years' => range((int)date('Y') - 2, (int)date('Y') + 1),
            'months' => [
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
            ]
        ];
    }
}



