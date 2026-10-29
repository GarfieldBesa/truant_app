<?php

namespace Tests\Feature;

use App\Models\Court;
use App\Models\CourtBooking;
use App\Models\CourtBookingRental;
use App\Models\CourtUnavailability;
use App\Models\RentalItem;
use App\Models\User;
use App\Services\CourtBookingService;
use Carbon\Carbon;
use Database\Seeders\CourtSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CourtBookingUpgradeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CourtSeeder::class);
    }

    public function test_only_pickle_ball_court_is_active_by_default(): void
    {
        $activeCourts = Court::active()->get();

        $this->assertCount(1, $activeCourts);
        $this->assertEquals('Pickle ball court', $activeCourts->first()->name);
        $this->assertEquals('pickleball', $activeCourts->first()->court_type);
        $this->assertEquals(350.00, $activeCourts->first()->hourly_rate);
    }

    public function test_admin_can_create_additional_courts(): void
    {
        $newCourt = Court::create([
            'name' => 'Badminton Court 1',
            'court_type' => 'pickleball',
            'default_slots_per_hour' => 4,
            'hourly_rate' => 300.00,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('courts', [
            'name' => 'Badminton Court 1',
            'slug' => 'badminton-court-1',
            'is_active' => true,
        ]);

        $this->assertCount(2, Court::active()->get());
    }

    public function test_month_availability_endpoint_returns_calendar_data(): void
    {
        $court = Court::where('slug', 'pickleball-court')->firstOrFail();
        $now = CourtBookingService::localNow();

        $response = $this->getJson(route('court-booking.monthAvailability', [
            'court_id' => $court->id,
            'year' => $now->year,
            'month' => $now->month,
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertEquals($court->id, $data['court_id']);
        $this->assertEquals($now->year, $data['year']);
        $this->assertEquals($now->month, $data['month']);
        $this->assertNotEmpty($data['days']);

        $firstDay = $data['days'][0];
        $this->assertArrayHasKey('date', $firstDay);
        $this->assertArrayHasKey('status', $firstDay);
        $this->assertArrayHasKey('color', $firstDay);

        // Future day should have status: available and color: green
        $futureDay = collect($data['days'])->firstWhere('is_past', false);
        if ($futureDay) {
            $this->assertContains($futureDay['color'], ['green', 'red']);
        }
    }

    public function test_rental_items_endpoint_returns_available_stock_per_slot(): void
    {
        $testDate = now()->addDays(3)->toDateString();
        $slotHour = 14;

        $response = $this->getJson(route('court-booking.rentalItems', [
            'date' => $testDate,
            'hour' => $slotHour,
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertEquals($testDate, $data['date']);
        $this->assertEquals($slotHour, $data['hour']);
        $this->assertNotEmpty($data['items']);

        $paddle = collect($data['items'])->firstWhere('slug', 'carbon-fiber-paddle');
        $this->assertNotNull($paddle);
        $this->assertEquals(12, $paddle['total_stock']);
        $this->assertEquals(12, $paddle['available_stock']);
        $this->assertTrue($paddle['is_in_stock']);
    }

    public function test_reservation_requires_terms_and_conditions_agreement(): void
    {
        $court = Court::where('slug', 'pickleball-court')->firstOrFail();
        $testDate = now()->addDays(2)->toDateString();
        $user = User::factory()->create();

        // 1. Omitted terms_agreed fails validation
        $response = $this->actingAs($user)->postJson(route('court-booking.reserve'), [
            'court_id' => $court->id,
            'booking_date' => $testDate,
            'start_hour' => 15,
            'slots_count' => 1,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_contact' => '09171234567',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['terms_agreed']);

        // 2. Unchecked (false) terms_agreed fails validation
        $response2 = $this->actingAs($user)->postJson(route('court-booking.reserve'), [
            'court_id' => $court->id,
            'booking_date' => $testDate,
            'start_hour' => 15,
            'slots_count' => 1,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_contact' => '09171234567',
            'terms_agreed' => 0,
        ]);

        $response2->assertStatus(422);
        $response2->assertJsonValidationErrors(['terms_agreed']);
    }

    public function test_reservation_with_rental_items_calculates_fees_and_deducts_inventory(): void
    {
        Mail::fake();

        $court = Court::where('slug', 'pickleball-court')->firstOrFail();
        $paddle = RentalItem::where('slug', 'carbon-fiber-paddle')->firstOrFail();
        $balls = RentalItem::where('slug', 'pickleball-balls-3pack')->firstOrFail();

        $testDate = now()->addDays(4)->toDateString();
        $slotHour = 16; // 4:00 PM

        $user = User::factory()->create([
            'email' => 'sara@example.com',
            'name' => 'Sara Smith',
        ]);

        $response = $this->actingAs($user)->postJson(route('court-booking.reserve'), [
            'court_id' => $court->id,
            'booking_date' => $testDate,
            'start_hour' => $slotHour,
            'slots_count' => 1,
            'customer_name' => 'Sara Smith',
            'customer_email' => 'sara@example.com',
            'customer_contact' => '09181112233',
            'terms_agreed' => 1,
            'rentals' => [
                [
                    'item_id' => $paddle->id,
                    'quantity' => 2,
                ],
                [
                    'item_id' => $balls->id,
                    'quantity' => 1,
                ],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Court fee = 350.00
        // Rentals fee = (2 * 50.00) + (1 * 30.00) = 130.00
        // Total = 480.00
        $booking = CourtBooking::where('customer_email', 'sara@example.com')->firstOrFail();
        $this->assertEquals(350.00, (float) $booking->court_fee);
        $this->assertEquals(130.00, (float) $booking->rentals_fee);
        $this->assertEquals(480.00, (float) $booking->total_amount);
        $this->assertTrue($booking->terms_agreed);

        // Check line items saved
        $this->assertCount(2, $booking->rentals);
        $this->assertDatabaseHas('court_booking_rentals', [
            'court_booking_id' => $booking->id,
            'rental_item_id' => $paddle->id,
            'quantity' => 2,
            'subtotal' => 100.00,
        ]);
        $this->assertDatabaseHas('court_booking_rentals', [
            'court_booking_id' => $booking->id,
            'rental_item_id' => $balls->id,
            'quantity' => 1,
            'subtotal' => 30.00,
        ]);

        // Stock deduction check for this exact slot
        $service = app(CourtBookingService::class);
        $availablePaddles = $service->getAvailableRentalItems($testDate, $slotHour);
        $paddleData = collect($availablePaddles)->firstWhere('id', $paddle->id);

        // Total was 12, rented 2 -> 10 available
        $this->assertEquals(10, $paddleData['available_stock']);

        // Another slot (e.g. 5:00 PM) still has full stock 12
        $otherSlotPaddles = $service->getAvailableRentalItems($testDate, 17);
        $otherPaddleData = collect($otherSlotPaddles)->firstWhere('id', $paddle->id);
        $this->assertEquals(12, $otherPaddleData['available_stock']);
    }

    public function test_rental_request_exceeding_slot_stock_is_rejected(): void
    {
        $court = Court::where('slug', 'pickleball-court')->firstOrFail();
        $eyewear = RentalItem::where('slug', 'protective-eyewear')->firstOrFail(); // stock 8

        $testDate = now()->addDays(5)->toDateString();
        $slotHour = 10;

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('court-booking.reserve'), [
            'court_id' => $court->id,
            'booking_date' => $testDate,
            'start_hour' => $slotHour,
            'slots_count' => 1,
            'customer_name' => 'Over Request User',
            'customer_email' => 'over@example.com',
            'customer_contact' => '09199998888',
            'terms_agreed' => true,
            'rentals' => [
                [
                    'item_id' => $eyewear->id,
                    'quantity' => 20, // Exceeds total stock of 8
                ],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['rentals']);
    }
}
