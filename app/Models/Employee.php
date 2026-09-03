<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'birthdate',
        'mobile_number',
        'username',
        'password',
        'position_id',
    ];

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
