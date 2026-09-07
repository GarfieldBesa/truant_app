<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'event_date',
        'registration_start_date',
        'registration_date',
        'banner',
        'admission',
        'ticket_price',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'registration_start_date' => 'date',
            'registration_date' => 'date',
        ];
    }

    public function isRegistrationOpen(): bool
    {
        $today = now()->startOfDay();

        if ($this->registrationForm && ! $this->registrationForm->is_open) {
            return false;
        }

        if ($this->registration_start_date && $today->lt($this->registration_start_date->startOfDay())) {
            return false;
        }

        if ($this->registration_date && $today->gt($this->registration_date->startOfDay())) {
            return false;
        }

        return true;
    }

    public function getRegistrationStatusAttribute(): string
    {
        $today = now()->startOfDay();

        if ($this->registrationForm && ! $this->registrationForm->is_open) {
            return 'Registration Closed';
        }

        if ($this->registration_start_date && $today->lt($this->registration_start_date->startOfDay())) {
            return 'Opens ' . $this->registration_start_date->format('M d, Y');
        }

        if ($this->registration_date && $today->gt($this->registration_date->startOfDay())) {
            return 'Registration Closed';
        }

        return 'Open';
    }

    public function isFreeAdmission(): bool
    {
        return strtolower((string) $this->admission) !== 'paid';
    }

    public function getAdmissionLabelAttribute(): string
    {
        return $this->isFreeAdmission() ? 'Free Admission' : 'Paid Admission';
    }

    public function registrationForm(): HasOne
    {
        return $this->hasOne(EventRegistrationForm::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(EventTeam::class);
    }
}
