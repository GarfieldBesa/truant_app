<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventRegistrationForm;
use App\Models\EventTeam;
use App\Models\EventTeamMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTeamRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Event $eventA;
    protected Event $eventB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'admin_team_test@example.com'],
            ['name' => 'Admin Team Tester', 'password' => bcrypt('password')]
        );

        $this->eventA = Event::create([
            'name' => 'Tech Tournament 2026',
            'description' => 'Annual coding tournament.',
            'event_date' => Carbon::now()->addDays(20)->toDateString(),
            'registration_start_date' => Carbon::now()->subDays(2)->toDateString(),
            'registration_date' => Carbon::now()->addDays(15)->toDateString(),
            'banner' => 'events/banners/tournament.jpg',
        ]);

        EventRegistrationForm::create([
            'event_id' => $this->eventA->id,
            'title' => 'Tournament Registration',
            'is_open' => true,
            'consent_title' => 'Terms of Participation',
            'consent_body' => 'I agree to tournament rules.',
            'consent_checkbox_label' => 'I agree to the terms',
            'fields' => [
                ['type' => 'text', 'label' => 'Full Name', 'is_required' => true],
            ],
        ]);

        $this->eventB = Event::create([
            'name' => 'Robotics Championship 2026',
            'description' => 'Robotics competition.',
            'event_date' => Carbon::now()->addDays(30)->toDateString(),
            'registration_start_date' => Carbon::now()->subDays(2)->toDateString(),
            'registration_date' => Carbon::now()->addDays(25)->toDateString(),
            'banner' => 'events/banners/robotics.jpg',
        ]);

        EventRegistrationForm::create([
            'event_id' => $this->eventB->id,
            'title' => 'Robotics Registration',
            'is_open' => true,
            'consent_title' => 'Robotics Rules',
            'consent_body' => 'I agree to robotics rules.',
            'consent_checkbox_label' => 'I agree',
            'fields' => [
                ['type' => 'text', 'label' => 'Full Name', 'is_required' => true],
            ],
        ]);
    }

    public function test_attendee_ref_is_reused_when_registering_for_multiple_events(): void
    {
        // 1. Register Jordan Bell for Event A
        $responseA = $this->post(route('events.public.register', $this->eventA), [
            'field_0' => 'Jordan Bell',
            'consent_agreed' => '1',
        ]);

        $responseA->assertRedirect(route('events.public.show', $this->eventA));
        $regA = EventRegistration::where('event_id', $this->eventA->id)->first();
        $this->assertNotNull($regA);
        $originalRef = $regA->registration_reference;
        $this->assertNotEmpty($originalRef);

        // 2. Register Jordan Bell for Event B without confirmation yet -> system prompts reuse
        $responseB = $this->post(route('events.public.register', $this->eventB), [
            'field_0' => 'Jordan Bell',
            'consent_agreed' => '1',
        ]);

        $responseB->assertSessionHas('ref_reuse_prompt', true);
        $responseB->assertSessionHas('existing_ref', $originalRef);
        $responseB->assertSessionHas('reuse_message', 'Information already exist Ref# will be reused to register on this event. Click to confirm and register');

        // Verify Event B does not have a registration yet
        $this->assertEquals(0, EventRegistration::where('event_id', $this->eventB->id)->count());

        // 3. Register Jordan Bell for Event B WITH confirmation
        $responseBConfirmed = $this->post(route('events.public.register', $this->eventB), [
            'field_0' => 'Jordan Bell',
            'consent_agreed' => '1',
            'confirm_reuse_ref' => '1',
            'reused_reference' => $originalRef,
        ]);

        $responseBConfirmed->assertRedirect(route('events.public.show', $this->eventB));
        $regB = EventRegistration::where('event_id', $this->eventB->id)->first();
        $this->assertNotNull($regB);

        // The reference must be reused!
        $this->assertEquals($originalRef, $regB->registration_reference);

        // 4. Jordan Bell attempting to register again for Event A is rejected
        $responseDuplicate = $this->post(route('events.public.register', $this->eventA), [
            'field_0' => 'Jordan Bell',
            'consent_agreed' => '1',
        ]);

        $responseDuplicate->assertSessionHas('error');
        $this->assertEquals(1, EventRegistration::where('event_id', $this->eventA->id)->count());
    }

    public function test_team_member_lookup_succeeds_for_current_event(): void
    {
        // Register an attendee for Event A
        $reg = EventRegistration::create([
            'event_id' => $this->eventA->id,
            'registration_reference' => 'REG-TEST-001',
            'data' => ['Full Name' => 'Samantha Reed'],
            'consent_agreed' => true,
        ]);

        $response = $this->postJson(route('events.public.teams.checkMember', $this->eventA), [
            'ref_code' => 'REG-TEST-001',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'name' => 'Samantha Reed',
            'ref' => 'REG-TEST-001',
        ]);
    }

    public function test_team_member_lookup_fails_if_registered_to_different_event(): void
    {
        // Register an attendee ONLY for Event B
        $regB = EventRegistration::create([
            'event_id' => $this->eventB->id,
            'registration_reference' => 'REG-ROBOTICS-002',
            'data' => ['Full Name' => 'Marcus Vance'],
            'consent_agreed' => true,
        ]);

        // Attempt lookup while on Event A
        $response = $this->postJson(route('events.public.teams.checkMember', $this->eventA), [
            'ref_code' => 'REG-ROBOTICS-002',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => false,
            'message' => 'Ref# is not registered to this event.',
        ]);
    }

    public function test_team_member_lookup_fails_for_non_existent_ref(): void
    {
        $response = $this->postJson(route('events.public.teams.checkMember', $this->eventA), [
            'ref_code' => 'REG-INVALID-999',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => false,
            'message' => 'Ref# is not registered to this event.',
        ]);
    }

    public function test_team_registration_succeeds_with_valid_members(): void
    {
        $p1 = EventRegistration::create([
            'event_id' => $this->eventA->id,
            'registration_reference' => 'REG-P1',
            'data' => ['Full Name' => 'Player One'],
            'consent_agreed' => true,
        ]);

        $p2 = EventRegistration::create([
            'event_id' => $this->eventA->id,
            'registration_reference' => 'REG-P2',
            'data' => ['Full Name' => 'Player Two'],
            'consent_agreed' => true,
        ]);

        $response = $this->post(route('events.public.teams.register', $this->eventA), [
            'team_name' => 'Cyber Hawks',
            'member_refs' => ['REG-P1', 'REG-P2'],
        ]);

        $response->assertRedirect(route('events.public.show', $this->eventA));
        $response->assertSessionHas('team_registration_success', true);
        $response->assertSessionHas('team_name', 'Cyber Hawks');

        $team = EventTeam::where('event_id', $this->eventA->id)->where('team_name', 'Cyber Hawks')->first();
        $this->assertNotNull($team);
        $this->assertStringStartsWith('TEAM-', $team->team_reference);
        $this->assertEquals(2, $team->members()->count());
    }

    public function test_team_name_cannot_be_duplicated_for_same_event(): void
    {
        $p1 = EventRegistration::create([
            'event_id' => $this->eventA->id,
            'registration_reference' => 'REG-A1',
            'data' => ['Full Name' => 'Leader One'],
            'consent_agreed' => true,
        ]);

        // Create first team
        EventTeam::create([
            'event_id' => $this->eventA->id,
            'team_name' => 'Alpha Titans',
        ]);

        // Attempt to register duplicate team name (case-insensitive)
        $response = $this->post(route('events.public.teams.register', $this->eventA), [
            'team_name' => 'alpha titans',
            'member_refs' => ['REG-A1'],
        ]);

        $response->assertSessionHasErrors('team_name');
        $this->assertEquals(1, EventTeam::where('event_id', $this->eventA->id)->count());
    }

    public function test_same_team_name_allowed_on_different_events(): void
    {
        $pA = EventRegistration::create([
            'event_id' => $this->eventA->id,
            'registration_reference' => 'REG-PA',
            'data' => ['Full Name' => 'Leader A'],
            'consent_agreed' => true,
        ]);

        $pB = EventRegistration::create([
            'event_id' => $this->eventB->id,
            'registration_reference' => 'REG-PB',
            'data' => ['Full Name' => 'Leader B'],
            'consent_agreed' => true,
        ]);

        // Register team Alpha on Event A
        $this->post(route('events.public.teams.register', $this->eventA), [
            'team_name' => 'Alpha Titans',
            'member_refs' => ['REG-PA'],
        ])->assertSessionHas('team_registration_success', true);

        // Register team Alpha on Event B -> should be allowed
        $this->post(route('events.public.teams.register', $this->eventB), [
            'team_name' => 'Alpha Titans',
            'member_refs' => ['REG-PB'],
        ])->assertSessionHas('team_registration_success', true);

        $this->assertEquals(1, EventTeam::where('event_id', $this->eventA->id)->count());
        $this->assertEquals(1, EventTeam::where('event_id', $this->eventB->id)->count());
    }

    public function test_admin_can_access_registered_teams_page(): void
    {
        $team = EventTeam::create([
            'event_id' => $this->eventA->id,
            'team_name' => 'Delta Force',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/events/registered-teams');
        $response->assertStatus(200);
        $response->assertSee('Registered Teams');
        $response->assertSee('Delta Force');
        $response->assertSee($team->team_reference);
    }

    public function test_existing_attendee_can_quick_register_for_another_event_by_entering_ref(): void
    {
        // 1. Initial registration for Event A
        $regA = EventRegistration::create([
            'event_id' => $this->eventA->id,
            'registration_reference' => 'REG-PLAYER-100',
            'data' => ['Full Name' => 'Taylor Swift', 'Email' => 'taylor@example.com'],
            'consent_agreed' => true,
        ]);

        // 2. Attendee visits Event B and enters Ref# to quick-register
        $response = $this->post(route('events.public.registerByRef', $this->eventB), [
            'ref_code' => 'REG-PLAYER-100',
        ]);

        $response->assertRedirect(route('events.public.show', $this->eventB));
        $response->assertSessionHas('registration_success', true);
        $response->assertSessionHas('reference_code', 'REG-PLAYER-100');

        // 3. Verify EventRegistration created for Event B with same Ref# and data
        $regB = EventRegistration::where('event_id', $this->eventB->id)
            ->where('registration_reference', 'REG-PLAYER-100')
            ->first();

        $this->assertNotNull($regB);
        $this->assertEquals('Taylor Swift', $regB->getAttendeeName());
    }

    public function test_attendee_registered_by_ref_can_be_added_to_team_on_new_event(): void
    {
        // 1. Player is in Team Alpha on Event A
        $regA = EventRegistration::create([
            'event_id' => $this->eventA->id,
            'registration_reference' => 'REG-PLAYER-200',
            'data' => ['Full Name' => 'Alex Morgan'],
            'consent_agreed' => true,
        ]);

        $teamA = EventTeam::create([
            'event_id' => $this->eventA->id,
            'team_name' => 'Alpha Warriors',
        ]);

        EventTeamMember::create([
            'event_team_id' => $teamA->id,
            'event_registration_id' => $regA->id,
            'registration_reference' => $regA->registration_reference,
            'member_name' => 'Alex Morgan',
        ]);

        // 2. Alex Morgan quick-registers for Event B by entering Ref#
        $this->post(route('events.public.registerByRef', $this->eventB), [
            'ref_code' => 'REG-PLAYER-200',
        ])->assertSessionHas('registration_success', true);

        // 3. Lookup on Event B succeeds
        $lookupResponse = $this->postJson(route('events.public.teams.checkMember', $this->eventB), [
            'ref_code' => 'REG-PLAYER-200',
        ]);
        $lookupResponse->assertStatus(200);
        $lookupResponse->assertJson([
            'success' => true,
            'name' => 'Alex Morgan',
            'ref' => 'REG-PLAYER-200',
        ]);

        // 4. Alex Morgan is added to a different team on Event B
        $teamBResponse = $this->post(route('events.public.teams.register', $this->eventB), [
            'team_name' => 'Beta Legends',
            'member_refs' => ['REG-PLAYER-200'],
        ]);
        $teamBResponse->assertSessionHas('team_registration_success', true);

        $teamB = EventTeam::where('event_id', $this->eventB->id)->where('team_name', 'Beta Legends')->first();
        $this->assertNotNull($teamB);
        $this->assertEquals(1, $teamB->members()->count());
        $this->assertEquals('REG-PLAYER-200', $teamB->members()->first()->registration_reference);

        // Both teams exist independently across the events!
        $this->assertEquals(1, $teamA->members()->count());
        $this->assertEquals(1, $teamB->members()->count());
    }

    public function test_quick_register_fails_with_invalid_reference(): void
    {
        $response = $this->post(route('events.public.registerByRef', $this->eventA), [
            'ref_code' => 'REG-DOES-NOT-EXIST',
        ]);

        $response->assertSessionHas('quick_reg_error');
        $this->assertEquals(0, EventRegistration::where('event_id', $this->eventA->id)->count());
    }

    public function test_quick_register_fails_if_already_registered_for_event(): void
    {
        EventRegistration::create([
            'event_id' => $this->eventA->id,
            'registration_reference' => 'REG-DUPLICATE-001',
            'data' => ['Full Name' => 'Existing Attendee'],
            'consent_agreed' => true,
        ]);

        $response = $this->post(route('events.public.registerByRef', $this->eventA), [
            'ref_code' => 'REG-DUPLICATE-001',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(1, EventRegistration::where('event_id', $this->eventA->id)->count());
    }
}
