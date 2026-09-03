<?php
use App\Models\Employee;
use App\Models\Timesheet;

$employee = Employee::where('first_name', 'like', '%Garfield%')
    ->where('last_name', 'like', '%Besa%')
    ->first();

if (!$employee) {
    echo "Employee Garfield Besa not found.\n";
    exit;
}

$startDate = '2026-08-01';
$endDate = '2026-08-15';

// Delete existing records for this period
Timesheet::where('employee_id', $employee->id)
    ->whereBetween('date', [$startDate, $endDate])
    ->delete();

// We are mapping the 14 data points from the image sequentially to Aug 1 to Aug 14
$data = [
    ['date' => '2026-08-01', 'time_in' => '08:49:00', 'time_out' => '17:30:00', 'force_meal_allowance' => true],
    ['date' => '2026-08-02', 'time_in' => '08:22:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-03', 'time_in' => '09:59:00', 'time_out' => '17:30:00', 'force_meal_allowance' => true],
    ['date' => '2026-08-04', 'time_in' => '08:30:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-05', 'time_in' => '08:30:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-06', 'time_in' => '08:47:00', 'time_out' => '17:30:00', 'force_meal_allowance' => true],
    ['date' => '2026-08-07', 'time_in' => '08:20:00', 'time_out' => '18:23:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-08', 'time_in' => '08:30:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-09', 'time_in' => '08:30:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-10', 'time_in' => '08:25:00', 'time_out' => '18:56:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-11', 'time_in' => '08:47:00', 'time_out' => '17:30:00', 'force_meal_allowance' => true],
    ['date' => '2026-08-12', 'time_in' => '08:30:00', 'time_out' => '18:51:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-13', 'time_in' => '09:12:00', 'time_out' => '19:19:00', 'force_meal_allowance' => true],
    ['date' => '2026-08-14', 'time_in' => '08:14:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
];

foreach ($data as $row) {
    Timesheet::create([
        'employee_id' => $employee->id,
        'date' => $row['date'],
        'time_in' => $row['time_in'],
        'time_out' => $row['time_out'],
        'is_on_leave' => false,
        'force_meal_allowance' => $row['force_meal_allowance'],
        'deduction' => 0.00,
        'extra_income' => 0.00,
    ]);
}

echo "Seeded timesheets for Garfield Besa (August 1-15).\n";
