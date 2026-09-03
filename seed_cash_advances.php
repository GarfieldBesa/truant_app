<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Employee;
use App\Models\CashAdvance;

$employees = Employee::all();

if ($employees->isEmpty()) {
    echo "No employees found to seed cash advances.\n";
    exit;
}

// Clean up existing to prevent duplicates during testing
CashAdvance::truncate();

// 1st Employee
CashAdvance::create([
    'employee_id' => $employees->first()->id,
    'amount' => 1500.00,
    'reason' => 'Car repair',
    'status' => 'pending',
]);

// 2nd Employee (if exists)
if ($employees->count() > 1) {
    CashAdvance::create([
        'employee_id' => $employees[1]->id,
        'amount' => 800.00,
        'reason' => 'Medical expenses',
        'status' => 'pending',
    ]);
}

echo "Successfully seeded test cash advance records!\n";
