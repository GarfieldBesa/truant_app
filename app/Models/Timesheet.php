<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'time_in',
        'time_out',
        'is_on_leave',
        'force_meal_allowance',
        'deduction',
        'deduction_description',
        'extra_income',
        'extra_income_description',
    ];

    protected $appends = [
        'has_meal_allowance',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_on_leave' => 'boolean',
            'force_meal_allowance' => 'boolean',
            'deduction' => 'decimal:2',
            'extra_income' => 'decimal:2',
        ];
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getHasMealAllowanceAttribute(): bool
    {
        if ($this->force_meal_allowance) {
            return true;
        }

        if ($this->is_on_leave) {
            return false;
        }

        if (!$this->time_in || !$this->time_out) {
            return false;
        }

        return $this->time_in <= '08:30:00' && $this->time_out >= '17:30:00';
    }
}
