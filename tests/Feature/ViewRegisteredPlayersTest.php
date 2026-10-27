<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventRegistrationForm;
use App\Models\EventTeam;
use App\Models\EventTeamMember;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewRegisteredPlayersTest extends TestCase
{
    use RefreshDatabase;

    protected Event $event;
    protected EventRegistration $player1;
    protected EventRegistration $player2;
    protected EventRegistration $playerSolo;
    protected EventTeam $teamAlpha;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create a scheduled event
        $this->event = Event::create([
            'name' => 'National Esports Championship 2026',
            'description' => 'The premier gaming championship.',
            'event_date' => Carbon::now()->addDays(20)->toDateString(),
            'registration_start_date' => Carbon::now()->subDays(2)->toDateString(),
            'registration_date' => Carbon::now()->addDays(15)->toDateString(),
            'banner' => 'events/banners/championship.jpg',
            'admission' => 'free',
        ]);

        EventRegistrationForm::create([
            'event_id' => $this->event->id,
            'title' => 'Championship Registration',
            'is_open' => true,
            'consent_title' => 'Terms',
            'consent_body' => 'I agree to event terms.',
            'consent_checkbox_label' => 'I agree',
            'fields' => [
                ['type' => 'text', 'label' => 'Full Name', 'is_required' => true],
            ],
        ]);

        // 2. Register Player 1 (Will be in Team Alpha)
        $this->player1 = EventRegistration::create([
            'event_id' => $this->event->id,
            'registration_reference' => 'REG-PLAYER-1',
            'data' => ['Full Name' => 'Marcus Vance'],
            'consent_agreed' => true,
        ]);

        // 3. Register Player 2 (Will be in Team Alpha)
        $this->player2 = EventRegistration::create([
            'event_id' => $this->event->id,
            'registration_reference' => 'REG-PLAYER-2',
            'data' => ['Full Name' => 'Elena Cruz'],
            'consent_agreed' => true,
        ]);

        // 4. Register Player Solo (Has NO team)
        $this->playerSolo = EventRegistration::create([
            'event_id' => $this->event->id,
            'registration_reference' => 'REG-SOLO-99',
            'data' => ['Full Name' => 'Lone Ranger'],
            'consent_agreed' => true,
        ]);

        // 5. Create Team Alpha and attach Player 1 & Player 2
        $this->teamAlpha = EventTeam::create([
            'event_id' => $this->event->id,
            'team_name' => 'Shadow Ravens',
            'team_reference' => 'TEAM-SHADOW-01',
        ]);

        EventTeamMember::create([
            'event_team_id' => $this->teamAlpha->id,
            'event_registration_id' => $this->player1->id,
            'registration_reference' => $this->player1->registration_reference,
            'member_name' => 'Marcus Vance',
        ]);

        EventTeamMember::create([
            'event_team_id' => $this->teamAlpha->id,
            'event_registration_id' => $this->player2->id,
            'registration_reference' => $this->player2->registration_reference,
            'member_name' => 'Elena Cruz',
        ]);
    }

    public function test_landing_page_scheduled_events_displays_view_registered_players_feature(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Scheduled Events');
        $response->assertSee('National Esports Championship 2026');

        // Check for Registered Players button on card
        $response->assertSee('Registered Players (3)');
        $response->assertSee('id="btn-view-players-' . $this->event->id . '"', false);

        // Check for embedded JSON roster data
        $response->assertSee('id="event-roster-data-' . $this->event->id . '"', false);
        $response->assertSee('Shadow Ravens');
        $response->assertSee('Marcus Vance');
        $response->assertSee('Elena Cruz');
        $response->assertSee('Lone Ranger');

        // Check for Roster Modal container
        $response->assertSee('id="rosterModalBackdrop"', false);
        $response->assertSee('Official Event Roster');
    }

    public function test_get_grouped_players_on_event_model(): void
    {
        $grouped = $this->event->getGroupedPlayers();

        $this->assertEquals(3, $grouped['total_players']);
        $this->assertEquals(1, $grouped['total_teams']);
        $this->assertEquals(1, $grouped['individual_players_count']);

        // Verify Team Alpha and members
        $this->assertCount(1, $grouped['teams']);
        $this->assertEquals('Shadow Ravens', $grouped['teams'][0]['team_name']);
        $this->assertEquals('TEAM-SHADOW-01', $grouped['teams'][0]['team_reference']);
        $this->assertCount(2, $grouped['teams'][0]['members']);
        $this->assertEquals('Marcus Vance', $grouped['teams'][0]['members'][0]['name']);
        $this->assertEquals('Elena Cruz', $grouped['teams'][0]['members'][1]['name']);

        // Verify Individual / Solo player
        $this->assertCount(1, $grouped['individual_players']);
        $this->assertEquals('Lone Ranger', $grouped['individual_players'][0]['name']);
        $this->assertEquals('REG-SOLO-99', $grouped['individual_players'][0]['reference']);
        $this->assertFalse($grouped['individual_players'][0]['has_team']);
    }

    public function test_api_endpoint_returns_registered_players_grouped_by_teams(): void
    {
        $response = $this->getJson(route('events.public.players', $this->event));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'event_id' => $this->event->id,
                'total_players' => 3,
                'total_teams' => 1,
                'individual_players_count' => 1,
                'teams' => [
                    [
                        'team_name' => 'Shadow Ravens',
                        'team_reference' => 'TEAM-SHADOW-01',
                        'members_count' => 2,
                        'members' => [
                            ['name' => 'Marcus Vance', 'reference' => 'REG-PLAYER-1'],
                            ['name' => 'Elena Cruz', 'reference' => 'REG-PLAYER-2'],
                        ],
                    ],
                ],
                'individual_players' => [
                    [
                        'name' => 'Lone Ranger',
                        'reference' => 'REG-SOLO-99',
                        'has_team' => false,
                    ],
                ],
            ],
        ]);
    }

    public function test_dedicated_registered_players_page_renders_correctly(): void
    {
        $response = $this->get(route('events.public.players', $this->event));

        $response->assertStatus(200);
        $response->assertSee('Registered Players — National Esports Championship 2026');
        $response->assertSee('Shadow Ravens');
        $response->assertSee('TEAM-SHADOW-01');
        $response->assertSee('Marcus Vance');
        $response->assertSee('Elena Cruz');
        $response->assertSee('Individual Players (No Team Yet)');
        $response->assertSee('Lone Ranger');
        $response->assertSee('REG-SOLO-99');
    }

    public function test_event_show_page_displays_registered_players_section(): void
    {
        $response = $this->get(route('events.public.show', $this->event));

        $response->assertStatus(200);
        $response->assertSee('Registered Players Directory');
        $response->assertSee('Shadow Ravens');
        $response->assertSee('Marcus Vance');
        $response->assertSee('Lone Ranger');
        $response->assertSee('View Registered Players (3)');
        $response->assertSee(route('events.public.players', $this->event));
    }

    public function test_event_with_no_registered_players_shows_empty_state(): void
    {
        $emptyEvent = Event::create([
            'name' => 'New Empty Tournament 2026',
            'description' => 'A tournament with no registrations yet.',
            'event_date' => Carbon::now()->addDays(40)->toDateString(),
            'registration_start_date' => Carbon::now()->subDays(1)->toDateString(),
            'registration_date' => Carbon::now()->addDays(35)->toDateString(),
            'banner' => 'events/banners/empty.jpg',
        ]);

        $grouped = $emptyEvent->getGroupedPlayers();
        $this->assertEquals(0, $grouped['total_players']);
        $this->assertEquals(0, $grouped['total_teams']);
        $this->assertEquals(0, $grouped['individual_players_count']);
        $this->assertEmpty($grouped['teams']);
        $this->assertEmpty($grouped['individual_players']);

        $response = $this->get(route('events.public.players', $emptyEvent));
        $response->assertStatus(200);
        $response->assertSee('No Players Registered Yet');
    }
}
