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
        'roles',
        'position_id',
    ];

    public function hasTimesheetPortalAccess(): bool
    {
        $roles = (array) ($this->roles ?? []);

        return in_array('timesheet_portal', $roles) || in_array('admin', $roles) || $this->role === 'timesheet_portal';
    }

    public function isAdmin(): bool
    {
        $roles = (array) ($this->roles ?? []);

        return in_array('admin', $roles);
    }

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'password' => 'hashed',
            'roles' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Employee $employee) {
            $roles = (array) ($employee->roles ?? []);
            if (in_array('admin', $roles)) {
                $employee->role = 'admin';
            } elseif (in_array('timesheet_portal', $roles)) {
                $employee->role = 'timesheet_portal';
            } else {
                $employee->role = 'employee';
            }
        });

        static::saved(function (Employee $employee) {
            $roles = (array) ($employee->roles ?? []);
            if (in_array('admin', $roles)) {
                $user = User::firstOrNew(['email' => $employee->username]);
                $user->name = "{$employee->first_name} {$employee->last_name}";
                $user->password = $employee->password;
                $user->save();
            } else {
                User::where('email', $employee->username)
                    ->where('email', '!=', 'admin@example.com')
                    ->delete();
            }
        });
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

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
