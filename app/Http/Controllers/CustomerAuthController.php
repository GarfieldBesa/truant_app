<?php

namespace App\Http\Controllers;

use App\Models\CourtBooking;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class CustomerAuthController extends Controller
{
    /**
     * Show customer login page.
     */
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended(route('customer.bookings'));
        }

        if ($request->has('redirect')) {
            session(['url.intended' => $request->query('redirect')]);
        }

        return view('auth.login');
    }

    /**
     * Authenticate customer with email and password.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt(['email' => strtolower(trim($validated['email'])), 'password' => $validated['password']], $remember)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The provided credentials do not match our records.',
                    'errors' => ['email' => ['Invalid email or password.']],
                ], 422);
            }

            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        $request->session()->regenerate();
        $user = Auth::user();

        // Associate existing bookings made with this email
        $this->syncPastBookings($user);

        $redirectUrl = session()->pull('url.intended', route('customer.bookings'));

        // If admin logs in through customer login, allow smooth transition or redirect
        if ($user->isAdmin() && str_contains($redirectUrl, 'admin')) {
            $redirectUrl = url('/admin');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'avatar_url' => $user->avatar_url,
                ],
                'redirect_url' => $redirectUrl,
            ]);
        }

        return redirect()->intended($redirectUrl);
    }

    /**
     * Show registration page.
     */
    public function showRegister(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended(route('customer.bookings'));
        }

        if ($request->has('redirect')) {
            session(['url.intended' => $request->query('redirect')]);
        }

        return view('auth.register');
    }

    /**
     * Register a new customer.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone_number' => 'nullable|string|max:50',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'phone_number' => $validated['phone_number'] ? trim($validated['phone_number']) : null,
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // Associate existing bookings made with this email
        $this->syncPastBookings($user);

        $redirectUrl = session()->pull('url.intended', route('customer.bookings'));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'avatar_url' => $user->avatar_url,
                ],
                'redirect_url' => $redirectUrl,
            ]);
        }

        return redirect()->to($redirectUrl);
    }

    /**
     * Redirect to Google OAuth consent screen.
     */
    public function redirectToGoogle(Request $request)
    {
        if ($request->has('redirect')) {
            session(['url.intended' => $request->query('redirect')]);
        }

        $clientId = config('services.google.client_id');
        if (empty($clientId)) {
            return redirect()->route('login')->with('warning', 'Google Sign-In credentials are not yet configured in the environment. Please log in or register with your email.');
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Throwable $e) {
            Log::warning('Google OAuth redirection error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to initiate Google Sign-In: ' . $e->getMessage());
        }
    }

    /**
     * Handle callback from Google OAuth.
     */
    public function handleGoogleCallback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('login')->with('error', 'Google sign-in was cancelled or failed.');
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            Log::warning('Google OAuth callback error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Failed retrieving your Google account details. Please try again.');
        }

        $email = strtolower(trim($googleUser->getEmail()));
        $googleId = (string) $googleUser->getId();
        $avatar = $googleUser->getAvatar();
        $name = $googleUser->getName() ?: 'Customer';

        // 1. Check if user exists by google_id
        $user = User::where('google_id', $googleId)->first();

        if (!$user) {
            // 2. Check if user exists with the same email
            $user = User::where('email', $email)->first();

            if ($user) {
                // Link Google account to existing user
                $user->update([
                    'google_id' => $googleId,
                    'avatar' => $avatar ?: $user->avatar,
                ]);
            } else {
                // 3. Create new customer user
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'google_id' => $googleId,
                    'avatar' => $avatar,
                    'role' => 'customer',
                    'email_verified_at' => now(),
                ]);
            }
        } else {
            // Update latest avatar
            if ($avatar && $avatar !== $user->avatar) {
                $user->update(['avatar' => $avatar]);
            }
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        // Associate existing bookings made with this email
        $this->syncPastBookings($user);

        $redirectUrl = session()->pull('url.intended', route('customer.bookings'));

        return redirect()->to($redirectUrl);
    }

    /**
     * Log out customer.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'You have been logged out.');
    }

    /**
     * Associate unlinked bookings matching the user's email to their user ID.
     */
    protected function syncPastBookings(User $user): void
    {
        try {
            CourtBooking::whereNull('user_id')
                ->where('customer_email', $user->email)
                ->update(['user_id' => $user->id]);
        } catch (\Throwable $e) {
            Log::warning("Could not sync past court bookings for {$user->email}: " . $e->getMessage());
        }
    }
}
