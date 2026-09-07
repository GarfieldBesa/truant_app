<?php

namespace Tests\Feature;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\CustomizeRegistrationForm;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Pages\ViewEventRegistrations;
use App\Filament\Resources\Events\Pages\ViewRegistrationForm;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventRegistrationForm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EventManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Tester', 'password' => bcrypt('password')]
        );
    }

    public function test_admin_can_access_events_index_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/events');
        $response->assertSuccessful();
    }

    public function test_admin_can_create_event_with_valid_dates(): void
    {
        $futureDate = Carbon::now()->addDays(10)->format('Y-m-d');
        $regDate = Carbon::now()->addDays(5)->format('Y-m-d');

        Livewire::actingAs($this->admin)
            ->test(CreateEvent::class)
            ->fillForm([
                'name' => 'Tech Summit 2026',
                'description' => '<p>Exciting annual conference on software engineering.</p>',
                'event_date' => $futureDate,
                'registration_date' => $regDate,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('events', [
            'name' => 'Tech Summit 2026',
        ]);

        $created = Event::where('name', 'Tech Summit 2026')->first();
        $this->assertNotNull($created);
        $this->assertEquals($futureDate, $created->event_date->format('Y-m-d'));
        $this->assertEquals($regDate, $created->registration_date->format('Y-m-d'));
    }

    public function test_event_date_cannot_be_in_the_past(): void
    {
        $pastDate = Carbon::now()->subDays(5)->format('Y-m-d');

        Livewire::actingAs($this->admin)
            ->test(CreateEvent::class)
            ->fillForm([
                'name' => 'Past Event Test',
                'description' => '<p>Invalid past event</p>',
                'event_date' => $pastDate,
                'registration_date' => $pastDate,
            ])
            ->call('create')
            ->assertHasFormErrors(['event_date']);
    }

    public function test_admin_can_edit_event(): void
    {
        $event = Event::create([
            'name' => 'Original Name',
            'description' => '<p>Original description</p>',
            'event_date' => Carbon::now()->addDays(14)->format('Y-m-d'),
            'registration_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
        ]);

        Livewire::actingAs($this->admin)
            ->test(EditEvent::class, ['record' => $event->getRouteKey()])
            ->fillForm([
                'name' => 'Updated Conference Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => 'Updated Conference Name',
        ]);
    }

    public function test_admin_can_delete_event_and_cascades_registration_form(): void
    {
        $event = Event::create([
            'name' => 'Event to Delete',
            'description' => '<p>Description</p>',
            'event_date' => Carbon::now()->addDays(14)->format('Y-m-d'),
            'registration_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
        ]);

        EventRegistrationForm::create([
            'event_id' => $event->id,
            'title' => 'Form for event to delete',
            'consent_body' => 'Consent text',
            'consent_checkbox_label' => 'I agree',
        ]);

        $this->assertDatabaseHas('events', ['id' => $event->id]);
        $this->assertDatabaseHas('event_registration_forms', ['event_id' => $event->id]);

        $event->delete();

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
        $this->assertDatabaseMissing('event_registration_forms', ['event_id' => $event->id]);
    }

    public function test_admin_can_customize_form_with_all_field_types_and_required_consent(): void
    {
        $event = Event::create([
            'name' => 'AI Conference 2026',
            'description' => '<p>All about artificial intelligence.</p>',
            'event_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
            'registration_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
        ]);

        $customFields = [
            [
                'label' => 'Full Name',
                'type' => 'text',
                'is_required' => true,
                'placeholder' => 'Enter your full name',
                'help_text' => 'As it appears on ID',
                'options' => [],
            ],
            [
                'label' => 'Experience Level',
                'type' => 'radio',
                'is_required' => true,
                'placeholder' => '',
                'help_text' => 'Pick one',
                'options' => ['Junior', 'Mid-level', 'Senior'],
            ],
            [
                'label' => 'Selected Track',
                'type' => 'select',
                'is_required' => true,
                'placeholder' => 'Select a track',
                'help_text' => 'Select preferred session',
                'options' => ['Track 1', 'Track 2'],
            ],
            [
                'label' => 'Dietary Needs',
                'type' => 'textarea',
                'is_required' => false,
                'placeholder' => 'Any food allergies?',
                'help_text' => 'Optional',
                'options' => [],
            ],
            [
                'label' => 'Upload Company Badge Photo',
                'type' => 'image_upload',
                'is_required' => false,
                'placeholder' => '',
                'help_text' => 'Photo ID',
                'options' => [],
            ],
        ];

        Livewire::actingAs($this->admin)
            ->test(CustomizeRegistrationForm::class, ['record' => $event->getRouteKey()])
            ->fillForm([
                'title' => 'Registration for AI Conference 2026',
                'description' => 'Please register early.',
                'consent_title' => 'Data Privacy Agreement',
                'consent_body' => 'I hereby authorize the event committee to handle my data.',
                'consent_checkbox_label' => 'I acknowledge and agree to the privacy policy.',
                'fields' => $customFields,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('event_registration_forms', [
            'event_id' => $event->id,
            'title' => 'Registration for AI Conference 2026',
            'consent_title' => 'Data Privacy Agreement',
            'consent_body' => 'I hereby authorize the event committee to handle my data.',
        ]);

        $form = EventRegistrationForm::where('event_id', $event->id)->first();
        $this->assertNotNull($form);
        $this->assertCount(5, $form->fields);
        $this->assertEquals('text', $form->fields[0]['type']);
        $this->assertEquals('radio', $form->fields[1]['type']);
        $this->assertEquals('select', $form->fields[2]['type']);
        $this->assertEquals('textarea', $form->fields[3]['type']);
        $this->assertEquals('image_upload', $form->fields[4]['type']);
    }

    public function test_consent_form_is_strictly_required_when_customizing_form(): void
    {
        $event = Event::create([
            'name' => 'Hackathon 2026',
            'description' => '<p>Hackathon weekend</p>',
            'event_date' => Carbon::now()->addDays(25)->format('Y-m-d'),
            'registration_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
        ]);

        Livewire::actingAs($this->admin)
            ->test(CustomizeRegistrationForm::class, ['record' => $event->getRouteKey()])
            ->fillForm([
                'title' => 'Hackathon Registration',
                'consent_body' => '', // Empty consent body
            ])
            ->call('save')
            ->assertHasFormErrors(['consent_body']);
    }

    public function test_admin_can_view_actual_created_registration_form(): void
    {
        $event = Event::create([
            'name' => 'Leadership Symposium 2026',
            'description' => '<p>Executive leadership symposium.</p>',
            'event_date' => Carbon::now()->addDays(18)->format('Y-m-d'),
            'registration_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
        ]);

        EventRegistrationForm::create([
            'event_id' => $event->id,
            'title' => 'Symposium Registration Form',
            'description' => 'Fill all required details below.',
            'consent_title' => 'Official Privacy Consent',
            'consent_body' => 'I voluntarily submit my information.',
            'consent_checkbox_label' => 'I agree to the terms of the symposium.',
            'fields' => [
                ['label' => 'Delegate Name', 'type' => 'text', 'is_required' => true, 'placeholder' => 'Full Name', 'help_text' => '', 'options' => []],
                ['label' => 'Dietary Option', 'type' => 'radio', 'is_required' => false, 'placeholder' => '', 'help_text' => '', 'options' => ['Standard', 'Vegetarian']],
            ],
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/events/{$event->id}/view-form");
        $response->assertSuccessful();
        $response->assertSee('Leadership Symposium 2026');
        $response->assertSee('Symposium Registration Form');
        $response->assertSee('Official Privacy Consent');
        $response->assertSee('Delegate Name');
        $response->assertSee('Dietary Option');
        $response->assertSee('Standard');
        $response->assertSee('Vegetarian');
    }

    public function test_interactive_preview_form_submission_validation(): void
    {
        $event = Event::create([
            'name' => 'Demo Conference 2026',
            'description' => '<p>Demo conference</p>',
            'event_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
            'registration_date' => Carbon::now()->addDays(8)->format('Y-m-d'),
        ]);

        EventRegistrationForm::create([
            'event_id' => $event->id,
            'title' => 'Demo Registration Form',
            'consent_title' => 'Terms of Attendance',
            'consent_body' => 'I agree to the terms.',
            'consent_checkbox_label' => 'I accept the terms.',
            'fields' => [
                ['label' => 'Attendee Name', 'type' => 'text', 'is_required' => true, 'placeholder' => '', 'help_text' => '', 'options' => []],
            ],
        ]);

        // 1. Fails when consent is unchecked
        Livewire::actingAs($this->admin)
            ->test(ViewRegistrationForm::class, ['record' => $event->getRouteKey()])
            ->set('formData.field_0', 'John Doe')
            ->set('consentAgreed', false)
            ->call('testSubmit')
            ->assertSet('previewValidationResult', null);

        // 2. Fails when required field is empty
        Livewire::actingAs($this->admin)
            ->test(ViewRegistrationForm::class, ['record' => $event->getRouteKey()])
            ->set('formData.field_0', '')
            ->set('consentAgreed', true)
            ->call('testSubmit')
            ->assertSet('previewValidationResult', null);

        // 3. Succeeds when required field and consent are valid
        Livewire::actingAs($this->admin)
            ->test(ViewRegistrationForm::class, ['record' => $event->getRouteKey()])
            ->set('formData.field_0', 'John Doe')
            ->set('consentAgreed', true)
            ->call('testSubmit')
            ->assertSet('previewValidationResult', 'All fields and consent requirements passed validation successfully!');
    }

    public function test_admin_can_save_and_render_form_specific_banner(): void
    {
        $event = Event::create([
            'name' => 'Design Expo 2026',
            'description' => '<p>Expo description</p>',
            'event_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'registration_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'banner' => 'events/banners/event_default.jpg',
        ]);

        EventRegistrationForm::create([
            'event_id' => $event->id,
            'title' => 'Design Expo Form',
            'banner' => 'events/form-banners/custom_form_banner.jpg',
            'consent_title' => 'Consent',
            'consent_body' => 'Consent text statement.',
            'consent_checkbox_label' => 'I agree.',
            'fields' => [
                ['label' => 'Name', 'type' => 'text', 'is_required' => true],
            ],
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/events/{$event->id}/view-form");
        $response->assertSuccessful();
        $response->assertSee('custom_form_banner.jpg');
    }

    public function test_admin_can_set_registration_start_date_and_open_status(): void
    {
        $startDate = Carbon::now()->addDays(2)->format('Y-m-d');
        $endDate = Carbon::now()->addDays(10)->format('Y-m-d');

        $event = Event::create([
            'name' => 'Future Summit 2026',
            'description' => '<p>Description</p>',
            'event_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'registration_start_date' => $startDate,
            'registration_date' => $endDate,
        ]);

        Livewire::actingAs($this->admin)
            ->test(CustomizeRegistrationForm::class, ['record' => $event->getRouteKey()])
            ->fillForm([
                'title' => 'Future Summit Registration',
                'registration_start_date' => $startDate,
                'registration_end_date' => $endDate,
                'is_open' => false,
                'consent_title' => 'Consent Agreement',
                'consent_body' => 'Mandatory consent statement for attendees.',
                'consent_checkbox_label' => 'I agree to the terms.',
                'fields' => [
                    ['label' => 'Attendee Name', 'type' => 'text', 'is_required' => true],
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('event_registration_forms', [
            'event_id' => $event->id,
            'is_open' => 0,
        ]);

        $savedForm = EventRegistrationForm::where('event_id', $event->id)->first();
        $this->assertNotNull($savedForm);
        $this->assertEquals($startDate, $savedForm->registration_start_date->format('Y-m-d'));
        $this->assertEquals($endDate, $savedForm->registration_end_date->format('Y-m-d'));
        $this->assertFalse($savedForm->is_open);

        $this->assertFalse($event->fresh()->isRegistrationOpen());
    }

    public function test_registration_open_status_calculation_and_view_rendering(): void
    {
        // 1. Event whose registration opens in the future
        $futureStart = Carbon::now()->addDays(3);
        $futureEnd = Carbon::now()->addDays(10);
        $event = Event::create([
            'name' => 'Upcoming Registration Event',
            'description' => '<p>Will open soon</p>',
            'event_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'registration_start_date' => $futureStart->format('Y-m-d'),
            'registration_date' => $futureEnd->format('Y-m-d'),
        ]);

        EventRegistrationForm::create([
            'event_id' => $event->id,
            'title' => 'Upcoming Form',
            'registration_start_date' => $futureStart->format('Y-m-d'),
            'registration_end_date' => $futureEnd->format('Y-m-d'),
            'is_open' => true,
            'consent_body' => 'Consent text.',
            'consent_checkbox_label' => 'I agree.',
            'fields' => [],
        ]);

        $this->assertFalse($event->isRegistrationOpen());
        $this->assertEquals('Opens ' . $futureStart->format('M d, Y'), $event->registration_status);

        $response = $this->actingAs($this->admin)->get("/admin/events/{$event->id}/view-form");
        $response->assertSuccessful();
        $response->assertSee('Registration Opens');
        $response->assertSee($futureStart->format('F d, Y'));

        // 2. Event currently open
        $pastStart = Carbon::now()->subDays(2);
        $event->update([
            'registration_start_date' => $pastStart->format('Y-m-d'),
        ]);
        $event->registrationForm->update([
            'registration_start_date' => $pastStart->format('Y-m-d'),
        ]);

        $this->assertTrue($event->fresh()->isRegistrationOpen());
        $this->assertEquals('Open', $event->fresh()->registration_status);

        // 3. Event where is_open is toggled off
        $event->registrationForm->update(['is_open' => false]);
        $this->assertFalse($event->fresh()->isRegistrationOpen());
        $this->assertEquals('Registration Closed', $event->fresh()->registration_status);
    }

    public function test_admin_can_access_event_registrations_page(): void
    {
        $event = Event::create([
            'name' => 'Design & Code Conference',
            'description' => '<p>Conference</p>',
            'event_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
            'registration_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
        ]);

        EventRegistrationForm::create([
            'event_id' => $event->id,
            'title' => 'Registration Form',
            'consent_body' => 'Consent text.',
            'consent_checkbox_label' => 'I agree.',
            'fields' => [
                ['label' => 'Attendee Name', 'type' => 'text', 'is_required' => true],
                ['label' => 'T-Shirt Size', 'type' => 'radio', 'is_required' => true, 'options' => ['Small', 'Medium', 'Large']],
            ],
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/events/{$event->id}/registrations");
        $response->assertSuccessful();
        $response->assertSee('Design & Code Conference');
        $response->assertSee('Print Attendees Report');
        $response->assertSee('Dynamic Column Filters');
        $response->assertSee('Attendee Name');
        $response->assertSee('T-Shirt Size');
    }

    public function test_dynamic_columns_and_filtering_on_registrations_page(): void
    {
        $event = Event::create([
            'name' => 'AI Innovate 2026',
            'description' => '<p>AI Expo</p>',
            'event_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'registration_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
        ]);

        EventRegistrationForm::create([
            'event_id' => $event->id,
            'title' => 'AI Innovate Form',
            'consent_body' => 'Consent text.',
            'consent_checkbox_label' => 'I agree.',
            'fields' => [
                ['label' => 'Full Name', 'type' => 'text', 'is_required' => true],
                ['label' => 'T-Shirt Size', 'type' => 'radio', 'is_required' => true, 'options' => ['Small', 'Medium', 'Large']],
                ['label' => 'Track', 'type' => 'select', 'is_required' => true, 'options' => ['Developer', 'Executive']],
            ],
        ]);

        $reg1 = EventRegistration::create([
            'event_id' => $event->id,
            'data' => [
                'Full Name' => 'Alice Walker',
                'T-Shirt Size' => 'Medium',
                'Track' => 'Developer',
            ],
            'consent_agreed' => true,
        ]);

        $reg2 = EventRegistration::create([
            'event_id' => $event->id,
            'data' => [
                'Full Name' => 'Bob Smith',
                'T-Shirt Size' => 'Large',
                'Track' => 'Executive',
            ],
            'consent_agreed' => true,
        ]);

        // Test Livewire component loading and dynamic filtering
        Livewire::actingAs($this->admin)
            ->test(ViewEventRegistrations::class, ['record' => $event->getRouteKey()])
            ->assertSee('Alice Walker')
            ->assertSee('Bob Smith')
            // Filter by T-Shirt Size = Medium
            ->set('selectedColumn', 'T-Shirt Size')
            ->set('filterValue', 'Medium')
            ->assertSee('Alice Walker')
            ->assertDontSee('Bob Smith')
            // Filter by T-Shirt Size = Large
            ->set('filterValue', 'Large')
            ->assertSee('Bob Smith')
            ->assertDontSee('Alice Walker')
            // Clear filter
            ->call('clearFilters')
            ->assertSee('Alice Walker')
            ->assertSee('Bob Smith')
            // Global search
            ->set('searchQuery', 'Executive')
            ->assertSee('Bob Smith')
            ->assertDontSee('Alice Walker');
    }

    public function test_event_deletion_cascades_registrations(): void
    {
        $event = Event::create([
            'name' => 'Temporary Event',
            'description' => '<p>Temporary</p>',
            'event_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'registration_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
        ]);

        $reg = EventRegistration::create([
            'event_id' => $event->id,
            'data' => ['Name' => 'John Doe'],
            'consent_agreed' => true,
        ]);

        $this->assertDatabaseHas('event_registrations', ['id' => $reg->id]);

        $event->delete();

        $this->assertDatabaseMissing('event_registrations', ['id' => $reg->id]);
    }
}
