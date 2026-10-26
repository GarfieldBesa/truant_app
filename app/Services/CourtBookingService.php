<?php

namespace App\Services;

use App\Mail\CourtBookingVerificationMail;
use App\Models\Court;
use App\Models\CourtBooking;
use App\Models\CourtUnavailability;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class CourtBookingService
{
    /**
     * Get Philippine Standard Time now.
     */
    public static function localNow(): Carbon
    {
        return Carbon::now('Asia/Manila');
    }

    /**
     * Get 24-hour slot breakdown for a court on a specific date.
     */
    public function getHourlySlotsForDate(Court $court, string $date): array
    {
        $now = self::localNow();
        $todayStr = $now->toDateString();
        $currentHour = $now->hour;

        $targetDate = Carbon::parse($date, 'Asia/Manila')->startOfDay();
        $targetDateStr = $targetDate->toDateString();
        $isToday = ($targetDateStr === $todayStr);
        $isPastDate = ($targetDateStr < $todayStr);

        // 1. Check Full-Day and Hourly Unavailabilities (Blackouts)
        $fullDayUnavailability = CourtUnavailability::where('court_id', $court->id)
            ->whereDate('date', $targetDateStr)
            ->whereNull('hour')
            ->first();

        $hourlyUnavailabilities = CourtUnavailability::where('court_id', $court->id)
            ->whereDate('date', $targetDateStr)
            ->whereNotNull('hour')
            ->pluck('reason', 'hour')
            ->toArray();

        // 2. Tally Bookings per hour
        // Include confirmed, verified, and unverified bookings created within the last 30 minutes
        $cutoffTime = now()->subMinutes(30);
        $activeBookings = CourtBooking::where('court_id', $court->id)
            ->whereDate('booking_date', $targetDateStr)
            ->where(function ($query) use ($cutoffTime) {
                $query->whereIn('status', ['confirmed', 'verified'])
                    ->orWhere(function ($q) use ($cutoffTime) {
                        $q->where('status', 'pending_verification')
                            ->where('created_at', '>=', $cutoffTime);
                    });
            })
            ->selectRaw('start_hour, SUM(slots_count) as total_booked')
            ->groupBy('start_hour')
            ->pluck('total_booked', 'start_hour')
            ->toArray();

        // 3. Generate 24 slots (0 to 23: 12 AM to 11 PM)
        $slots = [];
        $defaultCapacity = $court->default_slots_per_hour ?? 4;

        for ($hour = 0; $hour < 24; $hour++) {
            $timeLabel = CourtBooking::formatHourRange($hour, $hour + 1);
            $isPast = $isPastDate || ($isToday && $hour <= $currentHour);
            $booked = (int) ($activeBookings[$hour] ?? 0);

            if ($isPast) {
                $status = 'passed';
                $availableSlots = 0;
                $reason = 'Slot Passed';
                $statusLabel = 'Slot Passed';
            } elseif ($fullDayUnavailability) {
                $status = 'closed';
                $availableSlots = 0;
                $reason = $fullDayUnavailability->reason ?: 'Court Closed / Unavailable';
                $statusLabel = 'Court Closed';
            } elseif (isset($hourlyUnavailabilities[$hour])) {
                $status = 'closed';
                $availableSlots = 0;
                $reason = $hourlyUnavailabilities[$hour] ?: 'Unavailable / Maintenance';
                $statusLabel = 'Unavailable';
            } else {
                $availableSlots = max(0, $defaultCapacity - $booked);

                if ($availableSlots <= 0) {
                    $status = 'fully_booked';
                    $reason = null;
                    $statusLabel = 'Fully Booked';
                } else {
                    $status = 'available';
                    $reason = null;
                    $statusLabel = "{$availableSlots} slot" . ($availableSlots === 1 ? '' : 's') . ' available';
                }
            }

            $isSelectable = ($status === 'available') && !$isPast;

            $slots[] = [
                'hour' => $hour,
                'start_hour' => $hour,
                'end_hour' => $hour + 1,
                'time_label' => $timeLabel,
                'total_capacity' => $defaultCapacity,
                'booked_slots' => $booked,
                'available_slots' => $availableSlots,
                'status' => $status,
                'status_label' => $statusLabel,
                'is_past' => $isPast,
                'is_selectable' => $isSelectable,
                'reason' => $reason,
            ];
        }

        return $slots;
    }

    /**
     * Create a pending reservation and dispatch email verification.
     */
    public function createPendingReservation(Court $court, array $data): CourtBooking
    {
        $date = Carbon::parse($data['booking_date'])->toDateString();
        $startHour = (int) $data['start_hour'];
        $slotsCount = (int) ($data['slots_count'] ?? 1);

        // Verify slot is available
        $slots = $this->getHourlySlotsForDate($court, $date);
        $selectedSlot = collect($slots)->firstWhere('hour', $startHour);

        if (!$selectedSlot || !$selectedSlot['is_selectable'] || $selectedSlot['available_slots'] < $slotsCount) {
            $errorMessage = ($selectedSlot && ($selectedSlot['is_past'] || $selectedSlot['status'] === 'passed'))
                ? 'This time slot has already passed. Please select an upcoming slot.'
                : 'The selected time slot is no longer available. Please select another slot.';

            throw ValidationException::withMessages([
                'start_hour' => [$errorMessage],
            ]);
        }

        $booking = CourtBooking::create([
            'court_id' => $court->id,
            'booking_date' => $date,
            'start_hour' => $startHour,
            'end_hour' => $startHour + 1,
            'slots_count' => $slotsCount,
            'customer_name' => trim($data['customer_name']),
            'customer_email' => strtolower(trim($data['customer_email'])),
            'customer_contact' => trim($data['customer_contact']),
            'notes' => $data['notes'] ?? null,
            'status' => 'pending_verification',
        ]);

        // Dispatch verification email
        $this->sendVerificationEmail($booking);

        return $booking;
    }

    /**
     * Send or resend verification email to customer.
     */
    public function sendVerificationEmail(CourtBooking $booking): bool
    {
        try {
            Mail::to($booking->customer_email)->send(new CourtBookingVerificationMail($booking));
            return true;
        } catch (\Throwable $e) {
            Log::warning("Failed sending court booking verification email to {$booking->customer_email}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Find booking by reference code or verification token.
     */
    public function findBooking(string $identifier): ?CourtBooking
    {
        return CourtBooking::where('reference_code', $identifier)
            ->orWhere('verification_token', $identifier)
            ->first();
    }

    /**
     * Verify booking via 6-digit passcode.
     */
    public function verifyPasscode(CourtBooking $booking, string $inputPasscode): CourtBooking
    {
        if ($booking->isVerified()) {
            return $booking;
        }

        if ($booking->passcode_attempts >= 5) {
            throw ValidationException::withMessages([
                'passcode' => ['Too many failed attempts. Please click "Resend Passcode" to receive a new code.'],
            ]);
        }

        if ($booking->isPasscodeExpired()) {
            throw ValidationException::withMessages([
                'passcode' => ['This passcode has expired. Please click "Resend Passcode" to receive a new one.'],
            ]);
        }

        $cleanInput = preg_replace('/\D/', '', $inputPasscode);
        $cleanActual = preg_replace('/\D/', '', (string) $booking->verification_passcode);

        if ($cleanInput !== $cleanActual) {
            $booking->increment('passcode_attempts');
            $remaining = max(0, 5 - $booking->fresh()->passcode_attempts);
            $msg = $remaining > 0
                ? "Incorrect passcode. {$remaining} attempt(s) remaining."
                : 'Incorrect passcode. Maximum attempts reached. Please request a new passcode.';

            throw ValidationException::withMessages([
                'passcode' => [$msg],
            ]);
        }

        $booking->update([
            'status' => 'verified',
            'verified_at' => now(),
            'passcode_attempts' => 0,
        ]);

        return $booking;
    }

    /**
     * Regenerate 6-digit passcode and resend email.
     */
    public function resendPasscode(CourtBooking $booking): CourtBooking
    {
        if ($booking->isVerified()) {
            throw ValidationException::withMessages([
                'passcode' => ['This reservation is already verified.'],
            ]);
        }

        $booking->update([
            'verification_passcode' => CourtBooking::generatePasscode(),
            'passcode_expires_at' => now()->addMinutes(30),
            'passcode_attempts' => 0,
        ]);

        $this->sendVerificationEmail($booking);

        return $booking;
    }

    /**
     * Verify email via token (optional direct fallback).
     */
    public function verifyToken(string $token): ?CourtBooking
    {
        $booking = CourtBooking::where('verification_token', $token)->first();

        if (!$booking) {
            return null;
        }

        if ($booking->status === 'pending_verification') {
            $booking->update([
                'status' => 'verified',
                'verified_at' => now(),
            ]);
        }

        return $booking;
    }

    /**
     * Confirm mode of payment and finalize booking.
     */
    public function confirmPaymentMode(CourtBooking $booking, string $paymentMode, ?string $paymentNotes = null): CourtBooking
    {
        $booking->update([
            'payment_mode' => $paymentMode,
            'payment_notes' => $paymentNotes,
            'status' => 'confirmed',
        ]);

        // Send Notification to Admins
        $this->notifyAdmins($booking);

        return $booking;
    }

    /**
     * Notify administrators of confirmed booking.
     */
    protected function notifyAdmins(CourtBooking $booking): void
    {
        try {
            $courtName = $booking->court->name ?? 'Court';
            $timeSlot = $booking->time_slot;
            $date = $booking->booking_date->format('M d, Y');
            $paymentLabel = $booking->payment_mode_label;

            $admins = User::all();
            foreach ($admins as $admin) {
                Notification::make()
                    ->title("New Court Booking Confirmed (#{$booking->reference_code})")
                    ->body("{$booking->customer_name} booked {$courtName} for {$date} ({$timeSlot}). Mode of Payment: {$paymentLabel}")
                    ->icon('heroicon-o-calendar-days')
                    ->success()
                    ->sendToDatabase($admin);
            }
        } catch (\Throwable $e) {
            Log::info("Admin court booking notification skipped or logged: " . $e->getMessage());
        }
    }
}
