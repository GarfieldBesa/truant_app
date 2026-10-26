<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CourtBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_code',
        'court_id',
        'booking_date',
        'start_hour',
        'end_hour',
        'slots_count',
        'customer_name',
        'customer_email',
        'customer_contact',
        'notes',
        'verification_token',
        'verification_passcode',
        'passcode_expires_at',
        'passcode_attempts',
        'verified_at',
        'payment_mode',
        'payment_notes',
        'status',
        'decline_reason',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date:Y-m-d',
            'start_hour' => 'integer',
            'end_hour' => 'integer',
            'slots_count' => 'integer',
            'passcode_attempts' => 'integer',
            'passcode_expires_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (CourtBooking $booking) {
            if (empty($booking->reference_code)) {
                $booking->reference_code = self::generateUniqueReference();
            }
            if (empty($booking->verification_token)) {
                $booking->verification_token = Str::random(60);
            }
            if (empty($booking->verification_passcode)) {
                $booking->verification_passcode = self::generatePasscode();
            }
            if (empty($booking->passcode_expires_at)) {
                $booking->passcode_expires_at = now()->addMinutes(30);
            }
            if (empty($booking->end_hour)) {
                $booking->end_hour = $booking->start_hour + 1;
            }
        });
    }

    public static function generatePasscode(): string
    {
        return str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function isPasscodeExpired(): bool
    {
        return $this->passcode_expires_at && now()->isAfter($this->passcode_expires_at);
    }

    public static function generateUniqueReference(): string
    {
        do {
            $ref = 'BK-' . date('Ymd') . '-' . strtoupper(Str::random(5));
        } while (self::where('reference_code', $ref)->exists());

        return $ref;
    }

    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }

    public function getTimeSlotAttribute(): string
    {
        return self::formatHourRange($this->start_hour, $this->end_hour);
    }

    public static function formatHourRange(int $startHour, ?int $endHour = null): string
    {
        $endHour = $endHour ?? ($startHour + 1);

        $startPeriod = $startHour < 12 ? 'AM' : 'PM';
        $startDisplay = $startHour % 12 === 0 ? 12 : $startHour % 12;

        $endPeriod = $endHour < 12 || $endHour === 24 ? 'AM' : 'PM';
        $endDisplay = $endHour % 12 === 0 ? 12 : $endHour % 12;

        return sprintf('%d:00 %s - %d:00 %s', $startDisplay, $startPeriod, $endDisplay, $endPeriod);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_verification' => 'Pending Verification',
            'verified' => 'Verified (Awaiting Payment Confirmed)',
            'confirmed' => 'Confirmed',
            'declined' => 'Declined',
            'cancelled' => 'Cancelled',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getPaymentModeLabelAttribute(): string
    {
        return match ($this->payment_mode) {
            'cash_on_site' => 'Cash on Site / Over the Counter',
            'gcash' => 'GCash / E-Wallet',
            'bank_transfer' => 'Bank Transfer',
            default => $this->payment_mode ? ucfirst(str_replace('_', ' ', $this->payment_mode)) : 'Not Selected',
        };
    }

    public function isVerified(): bool
    {
        return !is_null($this->verified_at) || in_array($this->status, ['verified', 'confirmed']);
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isDeclined(): bool
    {
        return $this->status === 'declined';
    }
}
