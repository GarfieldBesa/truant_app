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
     * Get monthly calendar availability overview for a court.
     * Returns an array of day objects for the given month with status (available, fully_booked, closed, passed)
     * and a green or red icon indicator.
     */
    public function getMonthAvailability(Court $court, int $year, int $month): array
    {
        $now = self::localNow();
        $todayStr = $now->toDateString();
        $currentHour = $now->hour;

        $startDate = Carbon::createFromDate($year, $month, 1, 'Asia/Manila')->startOfDay();
        $daysInMonth = $startDate->daysInMonth;
        $endDate = $startDate->copy()->endOfMonth();

        // 1. Fetch blackouts in this month
        $fullDayBlackouts = CourtUnavailability::where('court_id', $court->id)
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->whereNull('hour')
            ->pluck('reason', 'date')
            ->toArray();

        $hourlyBlackouts = CourtUnavailability::where('court_id', $court->id)
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->whereNotNull('hour')
            ->get()
            ->groupBy(fn ($item) => Carbon::parse($item->date)->toDateString());

        // 2. Fetch active bookings in this month grouped by date and hour
        $cutoffTime = now()->subMinutes(30);
        $bookings = CourtBooking::where('court_id', $court->id)
            ->whereBetween('booking_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->where(function ($query) use ($cutoffTime) {
                $query->whereIn('status', ['confirmed', 'verified'])
                    ->orWhere(function ($q) use ($cutoffTime) {
                        $q->where('status', 'pending_verification')
                            ->where('created_at', '>=', $cutoffTime);
                    });
            })
            ->selectRaw('booking_date, start_hour, SUM(slots_count) as total_booked')
            ->groupBy('booking_date', 'start_hour')
            ->get()
            ->groupBy(fn ($item) => Carbon::parse($item->booking_date)->toDateString());

        $defaultCapacity = $court->default_slots_per_hour ?? 4;
        $calendarDays = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateObj = Carbon::createFromDate($year, $month, $day, 'Asia/Manila')->startOfDay();
            $dateStr = $dateObj->toDateString();
            $isToday = ($dateStr === $todayStr);
            $isPast = ($dateStr < $todayStr);

            $dayBlackout = $fullDayBlackouts[$dateStr] ?? null;
            $dayHourlyBlackouts = isset($hourlyBlackouts[$dateStr])
                ? $hourlyBlackouts[$dateStr]->keyBy('hour')
                : collect();
            $dayBookings = isset($bookings[$dateStr])
                ? $bookings[$dateStr]->keyBy('start_hour')
                : collect();

            if ($isPast) {
                $status = 'passed';
                $color = 'gray';
                $availableHours = 0;
            } elseif ($dayBlackout) {
                $status = 'closed';
                $color = 'red';
                $availableHours = 0;
            } else {
                // Check all remaining hours for that date
                $availableHours = 0;
                for ($h = 0; $h < 24; $h++) {
                    if ($isToday && $h <= $currentHour) {
                        continue;
                    }
                    if ($dayHourlyBlackouts->has($h)) {
                        continue;
                    }
                    $bookedSlots = (int) ($dayBookings->has($h) ? $dayBookings[$h]->total_booked : 0);
                    if ($bookedSlots < $defaultCapacity) {
                        $availableHours++;
                    }
                }

                if ($availableHours > 0) {
                    $status = 'available';
                    $color = 'green';
                } else {
                    $status = 'fully_booked';
                    $color = 'red';
                }
            }

            $calendarDays[] = [
                'date' => $dateStr,
                'day' => $day,
                'day_of_week' => $dateObj->dayOfWeek,
                'is_today' => $isToday,
                'is_past' => $isPast,
                'status' => $status,
                'color' => $color,
                'available_hours_count' => $availableHours,
                'is_selectable' => in_array($status, ['available', 'fully_booked']) && !$isPast,
            ];
        }

        return $calendarDays;
    }

    /**
     * Get active rental items with available stock computed for a specific date and hour slot.
     */
    public function getAvailableRentalItems(string $date, int $hour): array
    {
        $items = \App\Models\RentalItem::active()->get();

        return $items->map(function (\App\Models\RentalItem $item) use ($date, $hour) {
            $available = $item->getAvailableStockForSlot($date, $hour);
            return [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
                'picture_url' => $item->picture_url,
                'description' => $item->description,
                'rental_price' => (float) $item->rental_price,
                'formatted_price' => '₱' . number_format($item->rental_price, 2),
                'total_stock' => $item->total_stock,
                'available_stock' => $available,
                'is_in_stock' => $available > 0,
            ];
        })->values()->toArray();
    }

    /**
     * Create a pending reservation and dispatch email verification.
     */
    public function createPendingReservation(Court $court, array $data, ?User $user = null): CourtBooking
    {
        // 1. Validate Terms Agreement
        if (empty($data['terms_agreed'])) {
            throw ValidationException::withMessages([
                'terms_agreed' => ['Please read and agree to the Terms and Conditions before proceeding.'],
            ]);
        }

        $user = $user ?? (auth()->check() ? auth()->user() : null);
        $userId = $user?->id;
        $isUserAuth = !is_null($user);
        $status = $isUserAuth ? 'verified' : 'pending_verification';
        $verifiedAt = $isUserAuth ? now() : null;

        $customerName = $user ? $user->name : trim($data['customer_name'] ?? '');
        $customerEmail = $user ? strtolower(trim($user->email)) : strtolower(trim($data['customer_email'] ?? ''));
        $customerContact = !empty($data['customer_contact'])
            ? trim($data['customer_contact'])
            : ($user?->phone_number ?? trim($data['customer_contact'] ?? ''));

        if (!$user && empty($customerEmail)) {
            throw ValidationException::withMessages([
                'auth' => ['Player information is required. Please sign in with Google or your email account to book.'],
            ]);
        }

        if ($user && empty($user->phone_number) && !empty($customerContact)) {
            $user->update(['phone_number' => $customerContact]);
        }

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

        // 2. Validate Rental Items and Available Inventory for this slot
        $rentalsData = $data['rentals'] ?? [];
        $rentalsToSave = [];
        $rentalsFee = 0.00;

        if (!empty($rentalsData) && is_array($rentalsData)) {
            foreach ($rentalsData as $rentalReq) {
                $itemId = (int) ($rentalReq['item_id'] ?? $rentalReq['id'] ?? 0);
                $qty = (int) ($rentalReq['quantity'] ?? $rentalReq['qty'] ?? 0);

                if ($qty <= 0) {
                    continue;
                }

                $rentalItem = \App\Models\RentalItem::where('id', $itemId)->where('is_active', true)->first();
                if (!$rentalItem) {
                    throw ValidationException::withMessages([
                        'rentals' => ['One or more selected equipment items are currently unavailable.'],
                    ]);
                }

                $availableStock = $rentalItem->getAvailableStockForSlot($date, $startHour);
                if ($qty > $availableStock) {
                    throw ValidationException::withMessages([
                        'rentals' => ["Requested quantity for '{$rentalItem->name}' exceeds stock. Only {$availableStock} available for this slot."],
                    ]);
                }

                $subtotalItem = round($qty * (float) $rentalItem->rental_price, 2);
                $rentalsFee += $subtotalItem;

                $rentalsToSave[] = [
                    'rental_item_id' => $rentalItem->id,
                    'quantity' => $qty,
                    'unit_price' => $rentalItem->rental_price,
                    'subtotal' => $subtotalItem,
                ];
            }
        }

        // Calculate fees
        $courtFee = round(($court->hourly_rate ?? 0.00) * $slotsCount, 2);
        $subtotal = round($courtFee + $rentalsFee, 2);

        // 3. Voucher & Secret Promo Calculation
        $voucher = null;
        $discountAmount = 0.00;
        if (!empty($data['voucher_code'])) {
            $voucherCode = strtoupper(trim($data['voucher_code']));
            $voucher = \App\Models\Voucher::where('code', $voucherCode)->first();

            if (!$voucher) {
                throw ValidationException::withMessages([
                    'voucher_code' => ['The voucher code entered is invalid or does not exist.'],
                ]);
            }

            $check = $voucher->validateUsability($user, $subtotal);
            if (!$check['valid']) {
                throw ValidationException::withMessages([
                    'voucher_code' => [$check['message']],
                ]);
            }

            $discountAmount = $voucher->calculateDiscount($subtotal);
        }

        $totalAmount = max(0.00, round($subtotal - $discountAmount, 2));

        // 4. Save Booking & Line Items in Transaction
        $booking = \Illuminate\Support\Facades\DB::transaction(function () use (
            $userId,
            $status,
            $verifiedAt,
            $court,
            $date,
            $startHour,
            $slotsCount,
            $courtFee,
            $rentalsFee,
            $voucher,
            $discountAmount,
            $totalAmount,
            $customerName,
            $customerEmail,
            $customerContact,
            $data,
            $rentalsToSave
        ) {
            $booking = CourtBooking::create([
                'user_id' => $userId,
                'court_id' => $court->id,
                'booking_date' => $date,
                'start_hour' => $startHour,
                'end_hour' => $startHour + 1,
                'slots_count' => $slotsCount,
                'court_fee' => $courtFee,
                'rentals_fee' => $rentalsFee,
                'voucher_id' => $voucher?->id,
                'voucher_code' => $voucher?->code,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'terms_agreed' => true,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'customer_contact' => $customerContact,
                'notes' => $data['notes'] ?? null,
                'status' => $status,
                'verified_at' => $verifiedAt,
            ]);

            if ($voucher) {
                $voucher->increment('times_used');
            }

            foreach ($rentalsToSave as $rental) {
                \App\Models\CourtBookingRental::create([
                    'court_booking_id' => $booking->id,
                    'rental_item_id' => $rental['rental_item_id'],
                    'quantity' => $rental['quantity'],
                    'unit_price' => $rental['unit_price'],
                    'subtotal' => $rental['subtotal'],
                ]);
            }

            return $booking;
        });

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
            $totalStr = $booking->total_amount > 0 ? " | Total: ₱" . number_format($booking->total_amount, 2) : "";
            $rentalsCount = $booking->rentals()->sum('quantity');
            $rentalsStr = $rentalsCount > 0 ? " ({$rentalsCount} rental item(s))" : "";

            foreach ($admins as $admin) {
                Notification::make()
                    ->title("New Court Booking Confirmed (#{$booking->reference_code})")
                    ->body("{$booking->customer_name} booked {$courtName} for {$date} ({$timeSlot}){$rentalsStr}. Payment: {$paymentLabel}{$totalStr}")
                    ->icon('heroicon-o-calendar-days')
                    ->success()
                    ->sendToDatabase($admin);
            }
        } catch (\Throwable $e) {
            Log::info("Admin court booking notification skipped or logged: " . $e->getMessage());
        }
    }

    /**
     * Secretly validate and compute discount for a voucher code.
     */
    public function validateAndCalculateVoucher(string $code, float $subtotal, ?User $user = null): array
    {
        $code = strtoupper(trim($code));
        $voucher = \App\Models\Voucher::where('code', $code)->first();

        if (!$voucher) {
            return [
                'valid' => false,
                'message' => 'The voucher code entered is invalid or does not exist.',
            ];
        }

        $check = $voucher->validateUsability($user, $subtotal);
        if (!$check['valid']) {
            return [
                'valid' => false,
                'message' => $check['message'],
            ];
        }

        $discount = $voucher->calculateDiscount($subtotal);
        $newTotal = max(0.00, round($subtotal - $discount, 2));

        return [
            'valid' => true,
            'voucher_id' => $voucher->id,
            'code' => $voucher->code,
            'name' => $voucher->name,
            'discount_type' => $voucher->discount_type,
            'discount_value' => (float) $voucher->discount_value,
            'discount_amount' => $discount,
            'formatted_discount' => number_format($discount, 2),
            'subtotal' => $subtotal,
            'total_amount' => $newTotal,
            'discounted_total' => $newTotal,
            'formatted_total' => number_format($newTotal, 2),
            'message' => "Secret voucher '{$voucher->code}' applied successfully! You saved ₱" . number_format($discount, 2) . ".",
        ];
    }
}
