<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventRegistrationForm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicEventsLandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_displays_events_and_pagination(): void
    {
        // Create 8 events to test 6 per page pagination
        for ($i = 1; $i <= 8; $i++) {
            $event = Event::create([
                'name' => "Summit Event {$i}",
                'description' => "Detailed overview and topics for Summit Event {$i}",
                'event_date' => Carbon::now()->addDays($i * 10)->toDateString(),
                'registration_start_date' => Carbon::now()->subDays(2)->toDateString(),
                'registration_date' => Carbon::now()->addDays(5)->toDateString(),
                'banner' => 'events/banners/sample.jpg',
            ]);

            EventRegistrationForm::create([
                'event_id' => $event->id,
                'title' => "Registration - {$event->name}",
                'is_open' => true,
                'consent_title' => 'Terms of Consent',
                'consent_body' => 'I agree to event terms.',
                'consent_checkbox_label' => 'I agree',
                'fields' => [
                    ['type' => 'text', 'label' => 'Full Name', 'is_required' => true],
                ],
            ]);
        }

        // Test Page 1
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Explore Upcoming Events');
        $response->assertSee('Summit Event 1');
        $response->assertSee('Summit Event 6');
        $response->assertDontSee('Summit Event 7'); // 6 per page
        $response->assertSee('Next &raquo;', false);

        // Test Page 2
        $responsePage2 = $this->get('/?page=2');
        $responsePage2->assertStatus(200);
        $responsePage2->assertSee('Summit Event 7');
        $responsePage2->assertSee('Summit Event 8');
        $responsePage2->assertSee('&laquo; Previous', false);
    }

    public function test_card_displays_banner_description_status_and_event_date(): void
    {
        $event = Event::create([
            'name' => 'Tech Masterclass 2026',
            'description' => 'A comprehensive masterclass on distributed systems architecture.',
            'event_date' => Carbon::now()->addDays(20)->toDateString(),
            'registration_start_date' => Carbon::now()->subDays(1)->toDateString(),
            'registration_date' => Carbon::now()->addDays(15)->toDateString(),
            'banner' => 'events/banners/tech_masterclass.jpg',
        ]);

        EventRegistrationForm::create([
            'event_id' => $event->id,
            'title' => 'Registration Form',
            'is_open' => true,
            'consent_title' => 'Terms of Consent',
            'consent_body' => 'I agree to event terms.',
            'consent_checkbox_label' => 'I agree',
            'fields' => [],
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Tech Masterclass 2026');
        $response->assertSee('tech_masterclass.jpg');
        $response->assertSee('Registration Open');
        $response->assertSee('A comprehensive masterclass on distributed systems');
        $response->assertSee(route('events.public.show', $event));
    }

    public function test_visitor_can_view_event_page_and_submit_registration(): void
    {
        Storage::fake('public');

        $event = Event::create([
            'name' => 'AI Innovators Conclave',
            'description' => 'The ultimate conclave for AI researchers.',
            'event_date' => Carbon::now()->addDays(30)->toDateString(),
            'registration_start_date' => Carbon::now()->subDays(1)->toDateString(),
            'registration_date' => Carbon::now()->addDays(25)->toDateString(),
            'banner' => 'events/banners/ai_conclave.jpg',
        ]);

        EventRegistrationForm::create([
            'event_id' => $event->id,
            'title' => 'Register for AI Conclave',
            'description' => 'Fill out your attendee badge details below.',
            'is_open' => true,
            'consent_title' => 'Privacy Consent',
            'consent_body' => 'We will keep your registration secure.',
            'consent_checkbox_label' => 'I agree to the privacy policy',
            'fields' => [
                ['type' => 'text', 'label' => 'Full Name', 'is_required' => true],
                ['type' => 'select', 'label' => 'Affiliation', 'options' => ['Industry', 'Academic', 'Student'], 'is_required' => true],
            ],
        ]);

        // 1. Visit event page content
        $response = $this->get(route('events.public.show', $event));
        $response->assertStatus(200);
        $response->assertSee('AI Innovators Conclave');
        $response->assertSee('Register for AI Conclave');
        $response->assertSee('I agree to the privacy policy');
        $response->assertSee('Confirm &amp; Complete Registration', false);

        // 2. Submit valid registration
        $postData = [
            'field_0' => 'Dr. Jane Smith',
            'field_1' => 'Industry',
            'consent_agreed' => '1',
        ];

        $postResponse = $this->post(route('events.public.register', $event), $postData);
        $postResponse->assertRedirect(route('events.public.show', $event));
        $postResponse->assertSessionHas('registration_success', true);

        $this->assertDatabaseHas('event_registrations', [
            'event_id' => $event->id,
            'consent_agreed' => 1,
        ]);

        $registration = EventRegistration::where('event_id', $event->id)->first();
        $this->assertNotNull($registration);
        $this->assertEquals('Dr. Jane Smith', $registration->getFieldValue('Full Name'));
        $this->assertStringStartsWith('REG-', $registration->registration_reference);
    }

    public function test_admission_field_displays_free_or_paid_on_landing_page_and_event_details(): void
    {
        // 1. Create a Free Admission event
        $freeEvent = Event::create([
            'name' => 'Community Coding Day',
            'description' => 'A relaxed Saturday coding session with peers.',
            'event_date' => Carbon::now()->addDays(15)->toDateString(),
            'registration_start_date' => Carbon::now()->subDays(2)->toDateString(),
            'registration_date' => Carbon::now()->addDays(10)->toDateString(),
            'banner' => 'events/banners/coding.jpg',
            'admission' => 'free',
        ]);

        EventRegistrationForm::create([
            'event_id' => $freeEvent->id,
            'title' => 'Registration Form',
            'is_open' => true,
            'consent_title' => 'Terms',
            'consent_body' => 'Agreement',
            'consent_checkbox_label' => 'Agree',
            'fields' => [],
        ]);

        // 2. Create a Paid Admission event
        $paidEvent = Event::create([
            'name' => 'Executive AI Masterclass',
            'description' => 'Intensive leadership training on artificial intelligence.',
            'event_date' => Carbon::now()->addDays(25)->toDateString(),
            'registration_start_date' => Carbon::now()->subDays(2)->toDateString(),
            'registration_date' => Carbon::now()->addDays(20)->toDateString(),
            'banner' => 'events/banners/masterclass.jpg',
            'admission' => 'paid',
            'ticket_price' => '₱2,500',
        ]);

        EventRegistrationForm::create([
            'event_id' => $paidEvent->id,
            'title' => 'Registration Form',
            'is_open' => true,
            'consent_title' => 'Terms',
            'consent_body' => 'Agreement',
            'consent_checkbox_label' => 'Agree',
            'fields' => [],
        ]);

        // Test landing page displays both Free and Paid admission in card description & pills
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Free Admission');
        $response->assertSee('Paid Admission');
        $response->assertSee('₱2,500');

        // Test Free event details page
        $freeResponse = $this->get(route('events.public.show', $freeEvent));
        $freeResponse->assertStatus(200);
        $freeResponse->assertSee('Free Admission');

        // Test Paid event details page
        $paidResponse = $this->get(route('events.public.show', $paidEvent));
        $paidResponse->assertStatus(200);
        $paidResponse->assertSee('Paid Admission (₱2,500)');
    }

    public function test_landing_page_does_not_display_portal_buttons_only_events_and_login(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('id="btn-login-header"', false);
        $response->assertSee('Login');
        $response->assertSee('Events');
        $response->assertDontSee('id="btn-clockin-header"', false);
        $response->assertDontSee('nav-portal-link', false);
        $response->assertDontSee('Timesheet Portal');
        $response->assertDontSee('Public Portals');
    }

    public function test_admin_logout_redirects_to_landing_page(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin_logout_test@example.com'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );

        $response = $this->actingAs($user)->post('/admin/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_portal_logout_redirects_to_landing_page(): void
    {
        $response = $this->post('/portal/logout');

        $response->assertRedirect('/');
    }
}
