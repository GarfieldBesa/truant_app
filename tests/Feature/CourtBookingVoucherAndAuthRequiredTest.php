<?php

namespace Tests\Feature;

use App\Models\Court;
use App\Models\CourtBooking;
use App\Models\RentalItem;
use App\Models\User;
use App\Models\Voucher;
use Database\Seeders\CourtSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourtBookingVoucherAndAuthRequiredTest extends TestCase
{
    use RefreshDatabase;

    protected Court $court;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CourtSeeder::class);
        $this->court = Court::where('slug', 'pickleball-court')->firstOrFail();
    }

    public function test_guest_cannot_reserve_court_without_authentication(): void
    {
        $response = $this->postJson(route('court-booking.reserve'), [
            'court_id' => $this->court->id,
            'booking_date' => now()->addDay()->toDateString(),
            'start_hour' => 14,
            'slots_count' => 1,
            'terms_agreed' => true,
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'auth_required' => true,
        ]);
        $this->assertDatabaseCount('court_bookings', 0);
    }

    public function test_authenticated_customer_reserves_without_manual_textfields_and_is_auto_filled(): void
    {
        $customer = User::factory()->create([
            'name' => 'Alex Morgan',
            'email' => 'alex@example.com',
            'phone_number' => '09171234567',
            'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)->postJson(route('court-booking.reserve'), [
            'court_id' => $this->court->id,
            'booking_date' => now()->addDay()->toDateString(),
            'start_hour' => 15,
            'slots_count' => 1,
            'terms_agreed' => true,
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'is_verified' => true,
        ]);

        $booking = CourtBooking::first();
        $this->assertNotNull($booking);
        $this->assertEquals($customer->id, $booking->user_id);
        $this->assertEquals('Alex Morgan', $booking->customer_name);
        $this->assertEquals('alex@example.com', $booking->customer_email);
        $this->assertEquals('09171234567', $booking->customer_contact);
        $this->assertEquals('verified', $booking->status);
        $this->assertEquals(350.00, (float) $booking->court_fee);
        $this->assertEquals(0.00, (float) $booking->discount_amount);
        $this->assertEquals(350.00, (float) $booking->total_amount);
    }

    public function test_apply_voucher_endpoint_validates_fixed_discount_secret_code(): void
    {
        $voucher = Voucher::create([
            'code' => 'PICKLE50',
            'name' => 'Pickleball Fan ₱50 Off',
            'discount_type' => 'fixed',
            'discount_value' => 50.00,
            'is_active' => true,
        ]);

        $response = $this->postJson(route('court-booking.applyVoucher'), [
            'voucher_code' => 'pickle50', // case-insensitive input
            'court_id' => $this->court->id,
            'slots_count' => 1,
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'voucher' => [
                'valid' => true,
                'code' => 'PICKLE50',
                'discount_amount' => 50.00,
                'subtotal' => 350.00,
                'discounted_total' => 300.00,
            ],
        ]);
    }

    public function test_apply_voucher_percentage_discount_with_equipment_rentals(): void
    {
        $voucher = Voucher::create([
            'code' => 'VIP20',
            'name' => 'VIP 20% Off',
            'discount_type' => 'percent',
            'discount_value' => 20.00,
            'is_active' => true,
        ]);

        $paddle = RentalItem::create([
            'name' => 'Tournament Paddle',
            'category' => 'paddles',
            'rental_price' => 75.00,
            'total_stock' => 10,
            'is_active' => true,
        ]);

        // Court fee = 350, 2 paddles = 150 -> Subtotal = 500
        // 20% of 500 = 100 discount -> Total = 400
        $response = $this->postJson(route('court-booking.applyVoucher'), [
            'voucher_code' => 'VIP20',
            'court_id' => $this->court->id,
            'slots_count' => 1,
            'rentals' => [
                ['item_id' => $paddle->id, 'quantity' => 2],
            ],
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'voucher' => [
                'valid' => true,
                'code' => 'VIP20',
                'discount_amount' => 100.00,
                'subtotal' => 500.00,
                'discounted_total' => 400.00,
            ],
        ]);
    }

    public function test_apply_voucher_fails_if_min_spend_not_met(): void
    {
        Voucher::create([
            'code' => 'BIGSPENDER',
            'name' => 'Big Spender Promo',
            'discount_type' => 'fixed',
            'discount_value' => 150.00,
            'min_spend' => 600.00,
            'is_active' => true,
        ]);

        $response = $this->postJson(route('court-booking.applyVoucher'), [
            'voucher_code' => 'BIGSPENDER',
            'court_id' => $this->court->id,
            'slots_count' => 1, // Subtotal 350 < 600
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);
        $this->assertStringContainsString('minimum booking subtotal', strtolower($response->json('message')));
    }

    public function test_expired_or_inactive_voucher_is_rejected(): void
    {
        Voucher::create([
            'code' => 'EXPIRED99',
            'name' => 'Old Promo',
            'discount_type' => 'fixed',
            'discount_value' => 99.00,
            'is_active' => false,
        ]);

        $response = $this->postJson(route('court-booking.applyVoucher'), [
            'voucher_code' => 'EXPIRED99',
            'court_id' => $this->court->id,
            'slots_count' => 1,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);
    }

    public function test_reserve_with_valid_secret_voucher_records_discount_and_updates_usage(): void
    {
        $customer = User::factory()->create([
            'name' => 'Carlos Yulo',
            'email' => 'carlos@example.com',
            'role' => 'customer',
        ]);

        $voucher = Voucher::create([
            'code' => 'CHAMPION100',
            'name' => 'Champion ₱100 Off',
            'discount_type' => 'fixed',
            'discount_value' => 100.00,
            'usage_limit' => 5,
            'times_used' => 0,
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)->postJson(route('court-booking.reserve'), [
            'court_id' => $this->court->id,
            'booking_date' => now()->addDays(2)->toDateString(),
            'start_hour' => 16,
            'slots_count' => 1,
            'voucher_code' => 'CHAMPION100',
            'terms_agreed' => true,
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'discount_amount' => 100.00,
            'voucher_code' => 'CHAMPION100',
        ]);

        $booking = CourtBooking::first();
        $this->assertNotNull($booking);
        $this->assertEquals($voucher->id, $booking->voucher_id);
        $this->assertEquals('CHAMPION100', $booking->voucher_code);
        $this->assertEquals(100.00, (float) $booking->discount_amount);
        $this->assertEquals(350.00, (float) $booking->court_fee);
        $this->assertEquals(250.00, (float) $booking->total_amount);

        $voucher->refresh();
        $this->assertEquals(1, $voucher->times_used);
    }

    public function test_frontend_does_not_display_list_of_vouchers_and_renders_login_mockup_components(): void
    {
        // Create some secret vouchers in database
        Voucher::create([
            'code' => 'SECRET_PROMO_CODE_ABC',
            'name' => 'Secret VIP ₱200 Voucher',
            'discount_type' => 'fixed',
            'discount_value' => 200.00,
            'is_active' => true,
        ]);

        $response = $this->get(route('court-booking.index'));
        $response->assertOk();

        // 1. Vouchers must NOT be publicly listed in frontend
        $response->assertDontSee('SECRET_PROMO_CODE_ABC');
        $response->assertDontSee('Secret VIP ₱200 Voucher');

        // 2. Secret voucher input box must be present
        $response->assertSee('Have a Voucher Code?');
        $response->assertSee('voucher-code-input');
        $response->assertSee('applySecretVoucher()');

        // 3. Player information card matching the mockup
        $response->assertSee('Player information');
        $response->assertSee('Contact details');
        $response->assertSee('Sign in to book');
        $response->assertSee('Your profile fills in contact details automatically');
        $response->assertSee('I have an account');
        $response->assertSee("I'm new here", false);
        $response->assertSee('Log in with Gmail');
        $response->assertSee('Sign in with email');
        $response->assertSee('OR USE EMAIL');
        $response->assertSee('New to Truant Enterprises?');

        // 4. Ensure no textfields for customer name and email in the review order modal
        $content = $response->getContent();
        $this->assertStringNotContainsString('<input type="text" id="cust-name"', $content);
        $this->assertStringNotContainsString('<input type="email" id="cust-email"', $content);
    }

    public function test_verification_receipt_displays_voucher_discount_line_item(): void
    {
        $customer = User::factory()->create([
            'name' => 'Liza Soberano',
            'email' => 'liza@example.com',
            'role' => 'customer',
        ]);

        $booking = CourtBooking::create([
            'court_id' => $this->court->id,
            'user_id' => $customer->id,
            'booking_date' => now()->addDays(3)->toDateString(),
            'start_hour' => 10,
            'end_hour' => 11,
            'slots_count' => 1,
            'customer_name' => 'Liza Soberano',
            'customer_email' => 'liza@example.com',
            'customer_contact' => '09191234567',
            'status' => 'verified',
            'verified_at' => now(),
            'court_fee' => 350.00,
            'rentals_fee' => 0.00,
            'discount_amount' => 70.00,
            'voucher_code' => 'LIZA70',
            'total_amount' => 280.00,
            'terms_agreed' => true,
        ]);

        $response = $this->actingAs($customer)->get(route('court-booking.verify', ['token' => $booking->verification_token]));
        $response->assertOk();
        $response->assertSee('Voucher Discount (LIZA70)');
        $response->assertSee('-₱70.00');
        $response->assertSee('₱280.00');
    }

    public function test_admin_can_access_filament_secret_vouchers_resource(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Manager',
            'email' => 'admin@truantenterprises.com',
            'role' => 'admin',
        ]);

        $voucher = Voucher::create([
            'code' => 'ADMINCODE123',
            'name' => 'Exclusive Admin Promo',
            'discount_type' => 'percent',
            'discount_value' => 15.00,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/vouchers');
        $response->assertOk();
        $response->assertSee('ADMINCODE123');
    }
}
