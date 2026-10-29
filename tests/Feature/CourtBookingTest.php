<?php

namespace Tests\Feature;

use App\Mail\CourtBookingVerificationMail;
use App\Models\Court;
use App\Models\CourtBooking;
use App\Models\CourtUnavailability;
use App\Models\User;
use App\Services\CourtBookingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CourtBookingTest extends TestCase
{
    use RefreshDatabase;

    protected Court $pickleballCourt;
    protected Court $basketballCourt;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pickleballCourt = Court::create([
            'name' => 'Pickleball Court',
            'slug' => 'pickleball-court',
            'court_type' => 'pickleball',
            'default_slots_per_hour' => 4,
            'hourly_rate' => 350.00,
            'is_active' => true,
        ]);

        $this->basketballCourt = Court::create([
            'name' => 'Basketball Court',
            'slug' => 'basketball-court',
            'court_type' => 'basketball',
            'default_slots_per_hour' => 4,
            'hourly_rate' => 600.00,
            'is_active' => true,
        ]);
    }

    public function test_court_booking_index_page_loads_successfully(): void
    {
        $response = $this->get(route('court-booking.index'));

        $response->assertStatus(200);
        $response->assertSee('Pickleball Court');
        $response->assertSee('Basketball Court');
        $response->assertSee('Book a Court');
        $response->assertSee('12:00 AM - 1:00 AM');
    }

    public function test_homepage_and_events_have_book_a_court_button(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('Book a Court');
    }

    public function test_hourly_slots_api_returns_24_slots_with_default_4_slots(): void
    {
        $tomorrow = now()->addDays(2)->toDateString();

        $response = $this->getJson(route('court-booking.slots', [
            'court_id' => $this->pickleballCourt->id,
            'date' => $tomorrow,
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertCount(24, $data['slots']);
        $firstSlot = $data['slots'][0];
        $this->assertEquals(0, $firstSlot['hour']);
        $this->assertEquals('12:00 AM - 1:00 AM', $firstSlot['time_label']);
        $this->assertEquals(4, $firstSlot['total_capacity']);
        $this->assertEquals(4, $firstSlot['available_slots']);
        $this->assertEquals('available', $firstSlot['status']);
        $this->assertTrue($firstSlot['is_selectable']);
    }

    public function test_blackout_hour_and_full_day_closures_mark_slots_closed(): void
    {
        $testDate = now()->addDays(3)->toDateString();

        // 1. Specific hour blackout (Hour 14: 2:00 PM - 3:00 PM)
        CourtUnavailability::create([
            'court_id' => $this->pickleballCourt->id,
            'date' => $testDate,
            'hour' => 14,
            'reason' => 'Scheduled Net Repair',
        ]);

        $service = app(CourtBookingService::class);
        $slots = $service->getHourlySlotsForDate($this->pickleballCourt, $testDate);

        $slot14 = collect($slots)->firstWhere('hour', 14);
        $this->assertEquals('closed', $slot14['status']);
        $this->assertEquals(0, $slot14['available_slots']);
        $this->assertFalse($slot14['is_selectable']);
        $this->assertEquals('Scheduled Net Repair', $slot14['reason']);

        // Other slots remain available
        $slot10 = collect($slots)->firstWhere('hour', 10);
        $this->assertEquals('available', $slot10['status']);
        $this->assertEquals(4, $slot10['available_slots']);

        // 2. Full-day blackout for Basketball Court
        CourtUnavailability::create([
            'court_id' => $this->basketballCourt->id,
            'date' => $testDate,
            'hour' => null,
            'reason' => 'Private League Tournament',
        ]);

        $bballSlots = $service->getHourlySlotsForDate($this->basketballCourt, $testDate);
        foreach ($bballSlots as $s) {
            $this->assertEquals('closed', $s['status']);
            $this->assertEquals(0, $s['available_slots']);
            $this->assertFalse($s['is_selectable']);
        }
    }

    public function test_customer_can_reserve_slot_and_receives_auto_verification(): void
    {
        Mail::fake();

        $bookingDate = now()->addDays(4)->toDateString();
        $user = User::factory()->create([
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'phone_number' => '09171234567',
        ]);

        $response = $this->actingAs($user)->postJson(route('court-booking.reserve'), [
            'court_id' => $this->pickleballCourt->id,
            'booking_date' => $bookingDate,
            'start_hour' => 10,
            'slots_count' => 1,
            'customer_name' => 'Maria Santos',
            'customer_email' => 'maria@example.com',
            'customer_contact' => '09171234567',
            'notes' => 'Please prepare 2 extra paddles',
            'terms_agreed' => true,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'reference_code', 'verification_url', 'is_verified']);
        $this->assertTrue($response->json('is_verified'));

        $booking = CourtBooking::where('customer_email', 'maria@example.com')->first();
        $this->assertNotNull($booking);
        $this->assertEquals('verified', $booking->status);
        $this->assertEquals(10, $booking->start_hour);
        $this->assertEquals(11, $booking->end_hour);
        $this->assertNotNull($booking->verification_token);
        $this->assertEquals($user->id, $booking->user_id);

        // Slot availability should now be 3 slots remaining
        $service = app(CourtBookingService::class);
        $slots = $service->getHourlySlotsForDate($this->pickleballCourt, $bookingDate);
        $slot10 = collect($slots)->firstWhere('hour', 10);
        $this->assertEquals(3, $slot10['available_slots']);
    }

    public function test_unverified_reservation_shows_passcode_prompt(): void
    {
        $booking = CourtBooking::create([
            'court_id' => $this->pickleballCourt->id,
            'booking_date' => now()->addDays(5)->toDateString(),
            'start_hour' => 15,
            'slots_count' => 1,
            'customer_name' => 'Carlos Reyes',
            'customer_email' => 'carlos@example.com',
            'customer_contact' => '09189876543',
            'status' => 'pending_verification',
        ]);

        $this->assertNull($booking->verified_at);

        $response = $this->get(route('court-booking.verify', ['token' => $booking->verification_token]));

        $response->assertStatus(200);
        $response->assertSee('Enter Verification Passcode');
        $response->assertSee('c****s@example.com');
    }

    public function test_customer_verifies_passcode_and_unlocks_payment(): void
    {
        $booking = CourtBooking::create([
            'court_id' => $this->pickleballCourt->id,
            'booking_date' => now()->addDays(5)->toDateString(),
            'start_hour' => 15,
            'slots_count' => 1,
            'customer_name' => 'Carlos Reyes',
            'customer_email' => 'carlos@example.com',
            'customer_contact' => '09189876543',
            'status' => 'pending_verification',
        ]);

        // 1. Invalid passcode rejected
        $badResponse = $this->postJson(route('court-booking.verifyPasscode'), [
            'reference_code' => $booking->reference_code,
            'passcode' => '000000',
        ]);
        $badResponse->assertStatus(422);
        $badResponse->assertJsonValidationErrors(['passcode']);
        $this->assertEquals(1, $booking->fresh()->passcode_attempts);

        // 2. Valid passcode accepted
        $goodResponse = $this->postJson(route('court-booking.verifyPasscode'), [
            'reference_code' => $booking->reference_code,
            'passcode' => $booking->verification_passcode,
        ]);
        $goodResponse->assertStatus(200);
        $goodResponse->assertJson(['success' => true]);

        $booking->refresh();
        $this->assertEquals('verified', $booking->status);
        $this->assertNotNull($booking->verified_at);

        // 3. Page now displays payment mode selection
        $viewResponse = $this->get(route('court-booking.verify', ['token' => $booking->verification_token]));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Schedule Summary &amp; Payment', false);
        $viewResponse->assertSee('Select Mode of Payment');
    }

    public function test_unverified_booking_cannot_confirm_payment(): void
    {
        $booking = CourtBooking::create([
            'court_id' => $this->basketballCourt->id,
            'booking_date' => now()->addDays(2)->toDateString(),
            'start_hour' => 18,
            'slots_count' => 2,
            'customer_name' => 'Unverified User',
            'customer_email' => 'unverified@example.com',
            'customer_contact' => '09221234567',
            'status' => 'pending_verification',
        ]);

        $response = $this->post(route('court-booking.confirmPayment', ['token' => $booking->verification_token]), [
            'payment_mode' => 'gcash',
        ]);

        $response->assertRedirect(route('court-booking.verify', ['token' => $booking->verification_token]));
        $response->assertSessionHasErrors(['passcode']);
        $this->assertEquals('pending_verification', $booking->fresh()->status);
    }

    public function test_customer_can_confirm_payment_mode(): void
    {
        $booking = CourtBooking::create([
            'court_id' => $this->basketballCourt->id,
            'booking_date' => now()->addDays(2)->toDateString(),
            'start_hour' => 18,
            'slots_count' => 2,
            'customer_name' => 'Coach Ben',
            'customer_email' => 'coach@example.com',
            'customer_contact' => '09221234567',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $response = $this->post(route('court-booking.confirmPayment', ['token' => $booking->verification_token]), [
            'payment_mode' => 'gcash',
            'payment_notes' => 'GCash Ref #9876543210',
        ]);

        $response->assertRedirect(route('court-booking.verify', ['token' => $booking->verification_token]));

        $booking->refresh();
        $this->assertEquals('confirmed', $booking->status);
        $this->assertEquals('gcash', $booking->payment_mode);
        $this->assertEquals('GCash Ref #9876543210', $booking->payment_notes);

        // Accessing the page now displays confirmed receipt
        $followResponse = $this->get(route('court-booking.verify', ['token' => $booking->verification_token]));
        $followResponse->assertStatus(200);
        $followResponse->assertSee('Court Reservation Confirmed!');
        $followResponse->assertSee('GCash Ref #9876543210');
    }

    public function test_resending_passcode_generates_new_passcode_and_resets_attempts(): void
    {
        Mail::fake();

        $booking = CourtBooking::create([
            'court_id' => $this->pickleballCourt->id,
            'booking_date' => now()->addDays(3)->toDateString(),
            'start_hour' => 9,
            'slots_count' => 1,
            'customer_name' => 'Dan Santos',
            'customer_email' => 'dan@example.com',
            'customer_contact' => '09190001122',
            'status' => 'pending_verification',
            'passcode_attempts' => 3,
        ]);

        $oldPasscode = $booking->verification_passcode;

        $response = $this->postJson(route('court-booking.resendPasscode'), [
            'reference_code' => $booking->reference_code,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $booking->refresh();
        $this->assertEquals(0, $booking->passcode_attempts);
        $this->assertNotNull($booking->verification_passcode);

        Mail::assertSent(CourtBookingVerificationMail::class, function ($mail) use ($booking) {
            return $mail->booking->id === $booking->id && $mail->hasTo('dan@example.com');
        });
    }

    public function test_admin_declining_schedule_frees_up_the_slot(): void
    {
        $targetDate = now()->addDays(6)->toDateString();

        // 4 slots booked for hour 20
        $booking = CourtBooking::create([
            'court_id' => $this->pickleballCourt->id,
            'booking_date' => $targetDate,
            'start_hour' => 20,
            'slots_count' => 4,
            'customer_name' => 'Team Alpha',
            'customer_email' => 'alpha@example.com',
            'customer_contact' => '09110000000',
            'status' => 'confirmed',
        ]);

        $service = app(CourtBookingService::class);
        $slots = $service->getHourlySlotsForDate($this->pickleballCourt, $targetDate);
        $slot20 = collect($slots)->firstWhere('hour', 20);
        $this->assertEquals(0, $slot20['available_slots']);
        $this->assertEquals('fully_booked', $slot20['status']);

        // Admin declines schedule
        $booking->update([
            'status' => 'declined',
            'decline_reason' => 'Emergency maintenance scheduled on lighting equipment',
        ]);

        // Slot availability should now be restored to 4
        $slotsAfter = $service->getHourlySlotsForDate($this->pickleballCourt, $targetDate);
        $slot20After = collect($slotsAfter)->firstWhere('hour', 20);
        $this->assertEquals(4, $slot20After['available_slots']);
        $this->assertEquals('available', $slot20After['status']);
    }

    public function test_current_date_passed_slots_are_disabled_and_labeled_as_slot_passed(): void
    {
        // Freeze time at 2:30 PM (14:30) on a test day in Asia/Manila
        Carbon::setTestNow(Carbon::parse('2026-10-26 14:30:00', 'Asia/Manila'));

        $today = Carbon::now('Asia/Manila')->toDateString();
        $service = app(CourtBookingService::class);
        $slots = $service->getHourlySlotsForDate($this->pickleballCourt, $today);

        // Hours 0 to 14 (12:00 AM to 2:00 PM) must be marked as passed and disabled
        for ($h = 0; $h <= 14; $h++) {
            $slot = collect($slots)->firstWhere('hour', $h);
            $this->assertTrue($slot['is_past'], "Hour {$h} should have is_past=true");
            $this->assertEquals('passed', $slot['status'], "Hour {$h} should have status=passed");
            $this->assertEquals('Slot Passed', $slot['status_label'], "Hour {$h} should be labeled Slot Passed");
            $this->assertFalse($slot['is_selectable'], "Hour {$h} should not be selectable");
            $this->assertEquals(0, $slot['available_slots'], "Hour {$h} should have 0 available slots");
        }

        // Future hours today (15 to 23: 3:00 PM to 11:00 PM) remain available
        for ($h = 15; $h < 24; $h++) {
            $slot = collect($slots)->firstWhere('hour', $h);
            $this->assertFalse($slot['is_past'], "Hour {$h} should not be past");
            $this->assertEquals('available', $slot['status'], "Hour {$h} should be available");
            $this->assertTrue($slot['is_selectable'], "Hour {$h} should be selectable");
            $this->assertEquals(4, $slot['available_slots'], "Hour {$h} should have 4 available slots");
        }

        // The web view for today displays "Slot Passed"
        $viewResponse = $this->get(route('court-booking.index', ['date' => $today]));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Slot Passed');

        // Attempting to reserve passed hour 10 should be rejected by validation
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('court-booking.reserve'), [
            'court_id' => $this->pickleballCourt->id,
            'booking_date' => $today,
            'start_hour' => 10,
            'slots_count' => 1,
            'customer_name' => 'Late Customer',
            'customer_email' => 'late@example.com',
            'customer_contact' => '09170001122',
            'terms_agreed' => true,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start_hour']);

        // Reset test time
        Carbon::setTestNow();
    }
}
