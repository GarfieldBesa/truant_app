<?php

namespace App\Http\Controllers;

use App\Models\CourtBooking;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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
        $clientSecret = config('services.google.client_secret');
        $redirectUri = config('services.google.redirect') ?: url('/auth/google/callback');

        if (empty($clientId) || $clientId === 'your_production_google_client_id' || empty($clientSecret) || $clientSecret === 'your_production_google_client_secret') {
            return redirect()->route('login')->with('warning', 'Google Sign-In is not yet configured with production credentials. Please enter your Google Client ID and Secret in server settings, or sign in / register with your email.');
        }

        try {
            if (class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
                return Socialite::driver('google')->redirect();
            }

            // Built-in OAuth2 redirect without external package requirement
            $state = bin2hex(random_bytes(16));
            session(['google_oauth_state' => $state]);

            $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'response_type' => 'code',
                'scope' => 'openid profile email',
                'state' => $state,
                'access_type' => 'online',
                'prompt' => 'select_account',
            ]);

            return redirect()->away($authUrl);
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

        $email = null;
        $googleId = null;
        $avatar = null;
        $name = null;

        try {
            if (class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
                $googleUser = Socialite::driver('google')->user();
                $email = strtolower(trim((string) $googleUser->getEmail()));
                $googleId = (string) $googleUser->getId();
                $avatar = $googleUser->getAvatar();
                $name = $googleUser->getName() ?: 'Customer';
            } else {
                $code = $request->query('code');
                $state = $request->query('state');
                $savedState = session()->pull('google_oauth_state');

                if (empty($code)) {
                    return redirect()->route('login')->with('error', 'Missing authorization code from Google.');
                }

                if (!empty($savedState) && $state !== $savedState) {
                    return redirect()->route('login')->with('error', 'Invalid Google authentication session. Please try again.');
                }

                $clientId = config('services.google.client_id');
                $clientSecret = config('services.google.client_secret');
                $redirectUri = config('services.google.redirect') ?: url('/auth/google/callback');

                // Exchange auth code for access token
                $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                    'code' => $code,
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'redirect_uri' => $redirectUri,
                    'grant_type' => 'authorization_code',
                ]);

                if (!$tokenResponse->successful()) {
                    Log::warning('Google token exchange failed: ' . $tokenResponse->body());
                    return redirect()->route('login')->with('error', 'Google token verification failed. Please try again.');
                }

                $accessToken = $tokenResponse->json('access_token');
                if (!$accessToken) {
                    return redirect()->route('login')->with('error', 'Google did not return an access token.');
                }

                $userResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');
                if (!$userResponse->successful()) {
                    Log::warning('Google userinfo fetch failed: ' . $userResponse->body());
                    return redirect()->route('login')->with('error', 'Failed retrieving profile information from Google.');
                }

                $userInfo = $userResponse->json();
                $email = strtolower(trim((string) ($userInfo['email'] ?? '')));
                $googleId = (string) ($userInfo['sub'] ?? '');
                $avatar = $userInfo['picture'] ?? null;
                $name = $userInfo['name'] ?? 'Customer';
            }
        } catch (\Throwable $e) {
            Log::warning('Google OAuth callback error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Failed retrieving your Google account details: ' . $e->getMessage());
        }

        if (empty($email)) {
            return redirect()->route('login')->with('error', 'Google did not provide a valid email address.');
        }

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
