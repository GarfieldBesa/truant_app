<?php

namespace App\Http\Controllers;

use App\Models\CourtBooking;
use App\Services\CourtBookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPortalController extends Controller
{
    /**
     * Display customer's booking history and account dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $today = CourtBookingService::localNow()->toDateString();
        $currentHour = CourtBookingService::localNow()->hour;

        // Fetch user's bookings (either linked by user_id or matching customer_email)
        $bookings = CourtBooking::with(['court', 'rentals.item'])
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('customer_email', $user->email);
            })
            ->orderBy('booking_date', 'desc')
            ->orderBy('start_hour', 'desc')
            ->get();

        // Categorize upcoming vs past
        $upcomingBookings = $bookings->filter(function ($b) use ($today, $currentHour) {
            $date = $b->booking_date->toDateString();
            if ($date > $today) return true;
            if ($date === $today && $b->start_hour > $currentHour) return true;
            return false;
        });

        $pastBookings = $bookings->filter(function ($b) use ($today, $currentHour) {
            $date = $b->booking_date->toDateString();
            if ($date < $today) return true;
            if ($date === $today && $b->start_hour <= $currentHour) return true;
            return false;
        });

        $stats = [
            'total_bookings' => $bookings->count(),
            'upcoming_count' => $upcomingBookings->count(),
            'confirmed_count' => $bookings->where('status', 'confirmed')->count(),
            'total_spent' => $bookings->whereIn('status', ['confirmed', 'verified'])->sum('total_amount'),
        ];

        return view('customer.bookings', [
            'user' => $user,
            'bookings' => $bookings,
            'upcomingBookings' => $upcomingBookings,
            'pastBookings' => $pastBookings,
            'stats' => $stats,
        ]);
    }
}
