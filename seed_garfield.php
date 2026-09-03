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

$startDate = '2026-08-16';
$endDate = '2026-08-31';

// Delete existing records for this period
Timesheet::where('employee_id', $employee->id)
    ->whereBetween('date', [$startDate, $endDate])
    ->delete();

$data = [
    ['date' => '2026-08-17', 'time_in' => '08:49:00', 'time_out' => '17:30:00', 'force_meal_allowance' => true],
    ['date' => '2026-08-18', 'time_in' => '08:22:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-19', 'time_in' => '09:59:00', 'time_out' => '17:30:00', 'force_meal_allowance' => true],
    ['date' => '2026-08-20', 'time_in' => '08:30:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-21', 'time_in' => '08:30:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-22', 'time_in' => '08:47:00', 'time_out' => '17:30:00', 'force_meal_allowance' => true],
    ['date' => '2026-08-23', 'time_in' => '08:20:00', 'time_out' => '18:23:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-24', 'time_in' => '08:30:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-25', 'time_in' => '08:30:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-26', 'time_in' => '08:25:00', 'time_out' => '18:56:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-27', 'time_in' => '08:47:00', 'time_out' => '17:30:00', 'force_meal_allowance' => true],
    ['date' => '2026-08-28', 'time_in' => '08:30:00', 'time_out' => '18:51:00', 'force_meal_allowance' => false],
    ['date' => '2026-08-29', 'time_in' => '09:12:00', 'time_out' => '19:19:00', 'force_meal_allowance' => true],
    ['date' => '2026-08-30', 'time_in' => '08:14:00', 'time_out' => '17:30:00', 'force_meal_allowance' => false],
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

echo "Seeded timesheets for Garfield Besa (August 16-31).\n";
