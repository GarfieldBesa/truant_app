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

    public function getAttendeeName(): string
    {
        $data = $this->data ?? [];

        // 1. Check Full Name
        foreach (['full name', 'fullname', 'name', 'attendee name', 'player name', 'participant name'] as $key) {
            foreach ($data as $k => $v) {
                if (strcasecmp(trim((string) $k), $key) === 0 && !empty($v) && is_string($v)) {
                    return trim($v);
                }
            }
        }

        // 2. Check First Name & Last Name
        $firstName = null;
        $lastName = null;
        foreach ($data as $k => $v) {
            if (strcasecmp(trim((string) $k), 'first name') === 0 && is_string($v)) {
                $firstName = trim($v);
            }
            if (strcasecmp(trim((string) $k), 'last name') === 0 && is_string($v)) {
                $lastName = trim($v);
            }
        }
        if ($firstName && $lastName) {
            return $firstName === $lastName ? $firstName : "{$firstName} {$lastName}";
        }
        if ($firstName) {
            return $firstName;
        }
        if ($lastName) {
            return $lastName;
        }

        // 3. Any key containing 'name'
        foreach ($data as $k => $v) {
            if (stripos((string) $k, 'name') !== false && !empty($v) && is_string($v)) {
                return trim($v);
            }
        }

        // 4. Fallback to first non-empty string in data
        foreach ($data as $v) {
            if (is_string($v) && !empty(trim($v))) {
                return trim($v);
            }
        }

        return 'Attendee ' . $this->registration_reference;
    }

    public static function extractNameFromData(array $data): ?string
    {
        // 1. Check Full Name
        foreach (['full name', 'fullname', 'name', 'attendee name', 'player name', 'participant name'] as $key) {
            foreach ($data as $k => $v) {
                if (strcasecmp(trim((string) $k), $key) === 0 && !empty($v) && is_string($v)) {
                    return trim($v);
                }
            }
        }

        // 2. Check First Name & Last Name
        $firstName = null;
        $lastName = null;
        foreach ($data as $k => $v) {
            if (strcasecmp(trim((string) $k), 'first name') === 0 && is_string($v)) {
                $firstName = trim($v);
            }
            if (strcasecmp(trim((string) $k), 'last name') === 0 && is_string($v)) {
                $lastName = trim($v);
            }
        }
        if ($firstName && $lastName) {
            return $firstName === $lastName ? $firstName : "{$firstName} {$lastName}";
        }
        if ($firstName) {
            return $firstName;
        }
        if ($lastName) {
            return $lastName;
        }

        // 3. Any key containing 'name'
        foreach ($data as $k => $v) {
            if (stripos((string) $k, 'name') !== false && !empty($v) && is_string($v)) {
                return trim($v);
            }
        }

        return null;
    }

    public static function findExistingByName(string $candidateName, ?int $excludeEventId = null): ?EventRegistration
    {
        $normalizedCandidate = strtolower(preg_replace('/\s+/', ' ', trim($candidateName)));
        if (empty($normalizedCandidate)) {
            return null;
        }

        $query = static::query();
        if ($excludeEventId !== null) {
            $query->where('event_id', '!=', $excludeEventId);
        }

        $registrations = $query->latest('id')->get();
        foreach ($registrations as $reg) {
            $regName = strtolower(preg_replace('/\s+/', ' ', $reg->getAttendeeName()));
            if ($regName === $normalizedCandidate) {
                return $reg;
            }
        }

        return null;
    }

    public static function findInEventByName(string $candidateName, int $eventId): ?EventRegistration
    {
        $normalizedCandidate = strtolower(preg_replace('/\s+/', ' ', trim($candidateName)));
        if (empty($normalizedCandidate)) {
            return null;
        }

        $registrations = static::where('event_id', $eventId)->get();
        foreach ($registrations as $reg) {
            $regName = strtolower(preg_replace('/\s+/', ' ', $reg->getAttendeeName()));
            if ($regName === $normalizedCandidate) {
                return $reg;
            }
        }

        return null;
    }

    public function getAllEventsForReference()
    {
        return static::where('registration_reference', $this->registration_reference)
            ->with('event')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function getAllTeamsForReference()
    {
        return EventTeamMember::where('registration_reference', $this->registration_reference)
            ->with(['team.event'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function getCombinedData(): array
    {
        $all = $this->getAllEventsForReference();
        $combined = [];
        foreach ($all as $reg) {
            if (is_array($reg->data)) {
                foreach ($reg->data as $k => $v) {
                    if (!isset($combined[$k]) || (empty($combined[$k]) && !empty($v))) {
                        $combined[$k] = $v;
                    }
                }
            }
        }
        return $combined;
    }
}
