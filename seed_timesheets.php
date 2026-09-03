<?php
use App\Models\Employee;
use App\Models\Timesheet;
use Carbon\Carbon;

$employees = Employee::all();
if ($employees->isEmpty()) { 
    echo "No employees found.\n"; 
    exit; 
} 

$startDate = Carbon::create(2026, 9, 1); 
$endDate = Carbon::create(2026, 9, 15); 

foreach ($employees as $emp) { 
    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) { 
        if ($date->isSunday()) continue; 
        
        // Randomly 5% absent
        if (rand(1, 100) <= 5) continue; 
        
        // Random time in between 8:00 and 8:50 (maybe a few lates after 8:45)
        $timeIn = $date->copy()->setTime(8, rand(0, 50), 0); 
        
        // Random time out between 5:00 PM (17:00) and 5:30 PM (17:30)
        $timeOut = $date->copy()->setTime(17, rand(0, 30), 0); 
        
        // Random overtime 20% of the time, add 1 to 3 hours
        if (rand(1, 100) <= 20) { 
            $timeOut->addHours(rand(1, 3)); 
        } 
        
        Timesheet::updateOrCreate(
            [
                'employee_id' => $emp->id, 
                'date' => $date->format('Y-m-d')
            ], 
            [
                'time_in' => $timeIn->format('H:i:s'), 
                'time_out' => $timeOut->format('H:i:s'), 
                'is_on_leave' => false, 
                'force_meal_allowance' => false, 
                'deduction' => rand(0, 1) ? 50 : 0, 
                'deduction_description' => 'Test Ded.', 
                'extra_income' => rand(0, 1) ? 100 : 0, 
                'extra_income_description' => 'Test Extra'
            ]
        ); 
    } 
} 
echo "Seeded timesheets for " . $employees->count() . " employees.\n";
