<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'court_type',
        'description',
        'default_slots_per_hour',
        'hourly_rate',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'default_slots_per_hour' => 'integer',
            'hourly_rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Court $court) {
            if (empty($court->slug)) {
                $baseSlug = \Illuminate\Support\Str::slug($court->name);
                $slug = $baseSlug;
                $counter = 1;
                while (self::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . (++$counter);
                }
                $court->slug = $slug;
            }
        });
    }

    public function unavailabilities(): HasMany
    {
        return $this->hasMany(CourtUnavailability::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(CourtBooking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getTypeNameAttribute(): string
    {
        return match ($this->court_type) {
            'pickleball' => 'Pickleball Court',
            'basketball' => 'Basketball Court',
            default => ucfirst(str_replace('_', ' ', (string) $this->court_type)),
        };
    }
}
