<?php

namespace Tests\Feature;

use App\Models\Court;
use App\Models\CourtBooking;
use App\Models\User;
use Database\Seeders\CourtSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class CustomerAuthAndBookingHistoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CourtSeeder::class);
    }

    public function test_customer_can_register_and_past_unlinked_bookings_are_synced(): void
    {
        Mail::fake();
        $court = Court::where('slug', 'pickleball-court')->firstOrFail();

        // 1. Create a prior guest booking with this email
        $pastBooking = CourtBooking::create([
            'court_id' => $court->id,
            'booking_date' => now()->addDays(2)->toDateString(),
            'start_hour' => 10,
            'end_hour' => 11,
            'slots_count' => 1,
            'customer_name' => 'Maria Santos',
            'customer_email' => 'maria@example.com',
            'customer_contact' => '09181234567',
            'status' => 'verified',
            'verified_at' => now(),
            'court_fee' => 350.00,
            'rentals_fee' => 0.00,
            'total_amount' => 350.00,
            'terms_agreed' => true,
        ]);

        $this->assertNull($pastBooking->user_id);

        // 2. Register account with same email
        $response = $this->post('/register', [
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'phone_number' => '09181234567',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('customer.bookings'));
        $this->assertAuthenticated();

        $user = User::where('email', 'maria@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('customer', $user->role);
        $this->assertTrue($user->isCustomer());
        $this->assertFalse($user->isAdmin());

        // 3. Verify the past booking is now linked to this user
        $pastBooking->refresh();
        $this->assertEquals($user->id, $pastBooking->user_id);
    }

    public function test_customer_can_login_with_email_and_password(): void
    {
        $user = User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $response = $this->post('/login', [
            'email' => 'juan@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('customer.bookings'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_google_oauth_callback_creates_and_authenticates_customer(): void
    {
        $socialiteUser = new SocialiteUser();
        $socialiteUser->id = 'google-123456789';
        $socialiteUser->name = 'Google Player';
        $socialiteUser->email = 'player@gmail.com';
        $socialiteUser->avatar = 'https://lh3.googleusercontent.com/a/avatar.jpg';

        Socialite::shouldReceive('driver->user')
            ->once()
            ->andReturn($socialiteUser);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('customer.bookings'));
        $this->assertAuthenticated();

        $user = User::where('email', 'player@gmail.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('google-123456789', $user->google_id);
        $this->assertEquals('Google Player', $user->name);
        $this->assertEquals('customer', $user->role);
        $this->assertEquals('https://lh3.googleusercontent.com/a/avatar.jpg', $user->avatar);
    }

    public function test_customer_portal_requires_authentication(): void
    {
        $response = $this->get('/my-bookings');
        $response->assertRedirect(route('login'));
    }

    public function test_customer_portal_displays_booking_history_and_summary(): void
    {
        $user = User::create([
            'name' => 'Carlos Reyes',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $court = Court::where('slug', 'pickleball-court')->firstOrFail();

        // Upcoming reservation
        $bookingUpcoming = CourtBooking::create([
            'user_id' => $user->id,
            'court_id' => $court->id,
            'booking_date' => now()->addDays(3)->toDateString(),
            'start_hour' => 14,
            'end_hour' => 15,
            'slots_count' => 1,
            'customer_name' => 'Carlos Reyes',
            'customer_email' => 'carlos@example.com',
            'customer_contact' => '0917-000-1111',
            'status' => 'verified',
            'verified_at' => now(),
            'court_fee' => 350.00,
            'rentals_fee' => 0.00,
            'total_amount' => 350.00,
            'terms_agreed' => true,
        ]);

        $response = $this->actingAs($user)->get('/my-bookings');

        $response->assertStatus(200);
        $response->assertSee('My Court Bookings');
        $response->assertSee($bookingUpcoming->reference_code);
        $response->assertSee('Carlos Reyes');
    }

    public function test_authenticated_booking_auto_verifies_and_skips_passcode(): void
    {
        Mail::fake();

        $user = User::create([
            'name' => 'Alice Guo',
            'email' => 'alice@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '0917-999-8888',
            'role' => 'customer',
        ]);

        $court = Court::where('slug', 'pickleball-court')->firstOrFail();
        $date = now()->addDays(1)->toDateString();

        $response = $this->actingAs($user)->postJson('/book-a-court/reserve', [
            'court_id' => $court->id,
            'booking_date' => $date,
            'start_hour' => 15,
            'slots_count' => 1,
            'customer_name' => 'Alice Guo',
            'customer_email' => 'alice@example.com',
            'customer_contact' => '0917-999-8888',
            'terms_agreed' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_verified' => true,
        ]);

        $booking = CourtBooking::where('customer_email', 'alice@example.com')->first();
        $this->assertNotNull($booking);
        $this->assertEquals($user->id, $booking->user_id);
        $this->assertEquals('verified', $booking->status);
        $this->assertNotNull($booking->verified_at);
    }

    public function test_guest_booking_requires_authentication(): void
    {
        Mail::fake();

        $court = Court::where('slug', 'pickleball-court')->firstOrFail();
        $date = now()->addDays(1)->toDateString();

        $response = $this->postJson('/book-a-court/reserve', [
            'court_id' => $court->id,
            'booking_date' => $date,
            'start_hour' => 16,
            'slots_count' => 1,
            'customer_name' => 'Guest Player',
            'customer_email' => 'guest@example.com',
            'customer_contact' => '0917-555-4444',
            'terms_agreed' => 1,
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'auth_required' => true,
        ]);

        $this->assertDatabaseMissing('court_bookings', [
            'customer_email' => 'guest@example.com',
        ]);
    }

    public function test_regular_customer_cannot_access_filament_admin_panel(): void
    {
        $customer = User::create([
            'name' => 'Regular Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $this->assertFalse($customer->canAccessPanel(new \Filament\Panel()));

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->assertTrue($admin->canAccessPanel(new \Filament\Panel()));
    }
}
