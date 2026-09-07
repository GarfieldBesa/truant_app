<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'registration_reference',
        'data',
        'consent_agreed',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'consent_agreed' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (EventRegistration $registration) {
            if (empty($registration->registration_reference)) {
                $registration->registration_reference = 'REG-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
            }
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getFieldValue(string $fieldLabel, $default = '—')
    {
        $data = $this->data ?? [];

        // 1. Direct label match
        if (array_key_exists($fieldLabel, $data)) {
            $val = $data[$fieldLabel];
            return is_array($val) ? implode(', ', $val) : ($val !== '' && $val !== null ? $val : $default);
        }

        // 2. Case-insensitive match
        foreach ($data as $k => $v) {
            if (strcasecmp(trim($k), trim($fieldLabel)) === 0) {
                return is_array($v) ? implode(', ', $v) : ($v !== '' && $v !== null ? $v : $default);
            }
        }

        return $default;
    }
}
