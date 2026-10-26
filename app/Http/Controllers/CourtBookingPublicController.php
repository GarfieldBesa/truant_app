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
            abort(503, 'Court booking is currently unavailable. No courts active.');
        }

        $selectedCourtId = $request->query('court_id', $courts->first()->id);
        $selectedCourt = $courts->firstWhere('id', $selectedCourtId) ?: $courts->first();

        $localToday = CourtBookingService::localNow()->toDateString();
        $selectedDate = $request->query('date', $localToday);
        // Ensure date is not in the past
        if (Carbon::parse($selectedDate, 'Asia/Manila')->startOfDay()->isBefore(CourtBookingService::localNow()->startOfDay())) {
            $selectedDate = $localToday;
        }

        $slots = $this->bookingService->getHourlySlotsForDate($selectedCourt, $selectedDate);

        return view('court-booking.index', [
            'courts' => $courts,
            'selectedCourt' => $selectedCourt,
            'selectedDate' => $selectedDate,
            'slots' => $slots,
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
     * Handle slot reservation form submission.
     */
    public function reserve(Request $request)
    {
        $validated = $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_hour' => 'required|integer|between:0,23',
            'slots_count' => 'nullable|integer|min:1|max:4',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_contact' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        $court = Court::findOrFail($validated['court_id']);

        try {
            $booking = $this->bookingService->createPendingReservation($court, $validated);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'reference_code' => $booking->reference_code,
                    'token' => $booking->verification_token,
                    'masked_email' => $this->maskEmail($booking->customer_email),
                    'message' => 'Verification passcode sent to ' . $this->maskEmail($booking->customer_email) . '! Please check your inbox.',
                    'verification_url' => route('court-booking.verify', ['token' => $booking->verification_token]),
                ]);
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
