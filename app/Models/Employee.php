<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'birthdate',
        'mobile_number',
        'username',
        'password',
        'role',
        'position_id',
    ];

    public function hasTimesheetPortalAccess(): bool
    {
        return $this->role === 'timesheet_portal';
    }

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'password' => 'hashed',
        ];
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function cashAdvances()
    {
        return $this->hasMany(CashAdvance::class);
    }
}
