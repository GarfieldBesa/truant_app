<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\CourtBooking;
use App\Services\CourtBookingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CourtBookingPublicController extends Controller
{
    public function __construct(
        protected CourtBookingService $bookingService
    ) {}

    /**
     * Display the court booking page.
     */
    public function index(Request $request)
    {
        $courts = Court::active()->get();

        if ($courts->isEmpty()) {
            if (Court::count() === 0) {
                try {
                    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'CourtSeeder', '--force' => true]);
                    $courts = Court::active()->get();
                } catch (\Throwable $e) {
                    // Fall through
                }
            }
        }

        if ($courts->isEmpty()) {
            abort(503, 'Court booking is currently unavailable. No courts active.');
        }

        // Default to "Pickle ball court" if present
        $pickleCourt = $courts->first(fn ($c) => str_contains(strtolower($c->name), 'pickle'));
        $defaultCourt = $pickleCourt ?: $courts->first();

        $selectedCourtId = $request->query('court_id', $defaultCourt->id);
        $selectedCourt = $courts->firstWhere('id', $selectedCourtId) ?: $defaultCourt;

        $localToday = CourtBookingService::localNow()->toDateString();
        $selectedDate = $request->query('date', $localToday);
        if (Carbon::parse($selectedDate, 'Asia/Manila')->startOfDay()->isBefore(CourtBookingService::localNow()->startOfDay())) {
            $selectedDate = $localToday;
        }

        $dateCarbon = Carbon::parse($selectedDate, 'Asia/Manila');
        $currentYear = $dateCarbon->year;
        $currentMonth = $dateCarbon->month;

        $slots = $this->bookingService->getHourlySlotsForDate($selectedCourt, $selectedDate);
        $monthAvailability = $this->bookingService->getMonthAvailability($selectedCourt, $currentYear, $currentMonth);
        $rentalItems = \App\Models\RentalItem::active()->get();
        $currentUser = auth()->user();

        return view('court-booking.index', [
            'courts' => $courts,
            'selectedCourt' => $selectedCourt,
            'selectedDate' => $selectedDate,
            'currentYear' => $currentYear,
            'currentMonth' => $currentMonth,
            'slots' => $slots,
            'monthAvailability' => $monthAvailability,
            'rentalItems' => $rentalItems,
            'currentUser' => $currentUser,
        ]);
    }

    /**
     * AJAX endpoint to get real-time slot availability for a court & date.
     */
    public function getSlots(Request $request): JsonResponse
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'date' => 'required|date',
        ]);

        $court = Court::findOrFail($request->court_id);
        $date = Carbon::parse($request->date)->toDateString();

        $slots = $this->bookingService->getHourlySlotsForDate($court, $date);

        return response()->json([
            'court' => [
                'id' => $court->id,
                'name' => $court->name,
                'type' => $court->court_type,
                'rate' => $court->hourly_rate ? number_format($court->hourly_rate, 2) : null,
                'default_slots' => $court->default_slots_per_hour,
            ],
            'date' => $date,
            'formatted_date' => Carbon::parse($date)->format('l, F j, Y'),
            'slots' => $slots,
        ]);
    }

    /**
     * AJAX endpoint to get whole month availability summary for calendar view.
     */
    public function getMonthAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'year' => 'required|integer|min:2020|max:2099',
            'month' => 'required|integer|between:1,12',
        ]);

        $court = Court::findOrFail($request->court_id);
        $year = (int) $request->year;
        $month = (int) $request->month;

        $days = $this->bookingService->getMonthAvailability($court, $year, $month);
        $monthCarbon = Carbon::createFromDate($year, $month, 1, 'Asia/Manila');

        return response()->json([
            'court_id' => $court->id,
            'year' => $year,
            'month' => $month,
            'month_label' => $monthCarbon->format('F Y'),
            'days' => $days,
        ]);
    }

    /**
     * AJAX endpoint to get available rental equipment for a selected date and hour.
     */
    public function getRentalItems(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'hour' => 'required|integer|between:0,23',
        ]);

        $items = $this->bookingService->getAvailableRentalItems($request->date, (int) $request->hour);

        return response()->json([
            'date' => $request->date,
            'hour' => (int) $request->hour,
            'items' => $items,
        ]);
    }

    /**
     * AJAX endpoint to secretly validate and apply a voucher promo code.
     */
    public function applyVoucher(Request $request): JsonResponse
    {
        $request->validate([
            'voucher_code' => 'required|string|max:50',
            'court_id' => 'required|exists:courts,id',
            'slots_count' => 'nullable|integer|min:1|max:4',
            'rentals' => 'nullable|array',
        ]);

        $court = Court::findOrFail($request->court_id);
        $slotsCount = (int) ($request->slots_count ?? 1);
        $courtFee = round(($court->hourly_rate ?? 0.00) * $slotsCount, 2);

        $rentalsFee = 0.00;
        $rentals = $request->input('rentals', []);
        if (is_array($rentals)) {
            foreach ($rentals as $rental) {
                $itemId = (int) ($rental['item_id'] ?? $rental['id'] ?? 0);
                $qty = (int) ($rental['quantity'] ?? $rental['qty'] ?? 0);
                if ($qty > 0) {
                    $item = \App\Models\RentalItem::where('id', $itemId)->where('is_active', true)->first();
                    if ($item) {
                        $rentalsFee += round($qty * (float) $item->rental_price, 2);
                    }
                }
            }
        }

        $subtotal = round($courtFee + $rentalsFee, 2);

        $result = $this->bookingService->validateAndCalculateVoucher(
            $request->voucher_code,
            $subtotal,
            $request->user()
        );

        if (!$result['valid']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'voucher' => $result,
        ]);
    }

    /**
     * Handle slot reservation form submission.
     */
    public function reserve(Request $request)
    {
        // Enforce player information / authentication
        if (!$request->user()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'auth_required' => true,
                    'message' => 'Player information is required. Please sign in with Google or create an account to book.',
                ], 401);
            }

            return redirect()->route('login', ['redirect' => url()->previous()])
                ->with('warning', 'Player information is required. Please sign in or create an account to book.');
        }

        $validated = $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_hour' => 'required|integer|between:0,23',
            'slots_count' => 'nullable|integer|min:1|max:4',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_contact' => 'nullable|string|max:50',
            'voucher_code' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'terms_agreed' => 'required|accepted',
            'rentals' => 'nullable|array',
            'rentals.*.id' => 'nullable|integer',
            'rentals.*.item_id' => 'nullable|integer',
            'rentals.*.quantity' => 'nullable|integer|min:0',
            'rentals.*.qty' => 'nullable|integer|min:0',
        ], [
            'terms_agreed.accepted' => 'You must check and agree to the Terms and Conditions before continuing to payment.',
            'terms_agreed.required' => 'You must check and agree to the Terms and Conditions before continuing to payment.',
        ]);

        $user = $request->user();
        $validated['customer_name'] = $user->name;
        $validated['customer_email'] = $user->email;
        $validated['customer_contact'] = !empty($validated['customer_contact'])
            ? trim($validated['customer_contact'])
            : ($user->phone_number ?? '');

        $court = Court::findOrFail($validated['court_id']);

        try {
            $booking = $this->bookingService->createPendingReservation($court, $validated, $user);
            $isVerified = $booking->isVerified();

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'is_verified' => $isVerified,
                    'reference_code' => $booking->reference_code,
                    'token' => $booking->verification_token,
                    'court_fee' => $booking->court_fee,
                    'rentals_fee' => $booking->rentals_fee,
                    'discount_amount' => $booking->discount_amount,
                    'voucher_code' => $booking->voucher_code,
                    'total_amount' => $booking->total_amount,
                    'masked_email' => $this->maskEmail($booking->customer_email),
                    'message' => $isVerified
                        ? 'Your court booking has been confirmed! Redirecting to confirmation & payment...'
                        : 'Verification passcode sent to ' . $this->maskEmail($booking->customer_email) . '! Please check your inbox.',
                    'verification_url' => route('court-booking.verify', ['token' => $booking->verification_token]),
                ]);
            }

            if ($isVerified) {
                return redirect()->route('court-booking.verify', ['token' => $booking->verification_token])
                    ->with('success', 'Your reservation is confirmed! You can now proceed to payment.');
            }

            return redirect()->route('court-booking.index', [
                'court_id' => $court->id,
                'date' => $validated['booking_date'],
            ])->with('verification_sent', [
                'reference_code' => $booking->reference_code,
                'email' => $booking->customer_email,
                'masked_email' => $this->maskEmail($booking->customer_email),
                'court_name' => $court->name,
                'time_slot' => $booking->time_slot,
                'date' => Carbon::parse($validated['booking_date'])->format('F d, Y'),
                'token' => $booking->verification_token,
                'total_amount' => $booking->total_amount,
            ]);
        } catch (ValidationException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        }
    }

    /**
     * Verify booking via 6-digit passcode.
     */
    public function verifyPasscode(Request $request): JsonResponse
    {
        $request->validate([
            'passcode' => 'required|string|min:4|max:10',
            'reference_code' => 'nullable|string',
            'token' => 'nullable|string',
        ]);

        $identifier = $request->reference_code ?: $request->token;
        if (!$identifier) {
            return response()->json(['success' => false, 'message' => 'Reservation reference or token is required.'], 400);
        }

        $booking = $this->bookingService->findBooking($identifier);
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Reservation not found.'], 404);
        }

        try {
            $this->bookingService->verifyPasscode($booking, $request->passcode);

            return response()->json([
                'success' => true,
                'message' => 'Passcode verified successfully! Proceeding to payment summary...',
                'redirect_url' => route('court-booking.verify', ['token' => $booking->verification_token]),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => collect($e->errors())->flatten()->first() ?: 'Invalid passcode.',
            ], 422);
        }
    }

    /**
     * Resend 6-digit verification passcode.
     */
    public function resendPasscode(Request $request): JsonResponse
    {
        $request->validate([
            'reference_code' => 'nullable|string',
            'token' => 'nullable|string',
        ]);

        $identifier = $request->reference_code ?: $request->token;
        if (!$identifier) {
            return response()->json(['success' => false, 'message' => 'Reservation reference is required.'], 400);
        }

        $booking = $this->bookingService->findBooking($identifier);
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Reservation not found.'], 404);
        }

        try {
            $this->bookingService->resendPasscode($booking);

            return response()->json([
                'success' => true,
                'message' => 'A new 6-digit passcode has been sent to ' . $this->maskEmail($booking->customer_email) . '.',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first() ?: 'Unable to resend passcode.',
            ], 422);
        }
    }

    /**
     * Show verification page with booking summary & payment mode selection.
     */
    public function showVerification(string $token)
    {
        $booking = CourtBooking::where('verification_token', $token)->first();

        if (!$booking) {
            return view('court-booking.verify', [
                'error' => 'Invalid or expired reservation link. Please make a new reservation.',
                'booking' => null,
                'isVerified' => false,
                'isConfirmed' => false,
                'maskedEmail' => '',
            ]);
        }

        return view('court-booking.verify', [
            'booking' => $booking,
            'isVerified' => $booking->isVerified(),
            'isConfirmed' => ($booking->status === 'confirmed'),
            'maskedEmail' => $this->maskEmail($booking->customer_email),
        ]);
    }

    /**
     * Confirm mode of payment and complete the reservation.
     */
    public function confirmPayment(Request $request, string $token)
    {
        $booking = CourtBooking::where('verification_token', $token)->firstOrFail();

        // Enforce verified status
        if (!$booking->isVerified()) {
            return redirect()->route('court-booking.verify', ['token' => $token])
                ->withErrors(['passcode' => 'You must verify your email with the 6-digit passcode before selecting a payment method.']);
        }

        $validated = $request->validate([
            'payment_mode' => 'required|in:cash_on_site,gcash,bank_transfer',
            'payment_notes' => 'nullable|string|max:500',
        ]);

        $booking = $this->bookingService->confirmPaymentMode($booking, $validated['payment_mode'], $validated['payment_notes'] ?? null);

        return redirect()->route('court-booking.verify', ['token' => $token])
            ->with('confirmed_success', true);
    }

    /**
     * Resend verification email for a booking reference.
     */
    public function resendVerification(Request $request): JsonResponse
    {
        return $this->resendPasscode($request);
    }

    /**
     * Mask customer email for security display (e.g. j***e@example.com).
     */
    protected function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return $email;
        }

        $name = $parts[0];
        $domain = $parts[1];
        $len = strlen($name);

        if ($len <= 2) {
            $maskedName = substr($name, 0, 1) . '*';
        } else {
            $maskedName = substr($name, 0, 1) . str_repeat('*', max(1, $len - 2)) . substr($name, -1);
        }

        return $maskedName . '@' . $domain;
    }
}
