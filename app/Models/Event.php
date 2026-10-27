<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'event_date',
        'registration_start_date',
        'registration_date',
        'banner',
        'admission',
        'ticket_price',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'registration_start_date' => 'date',
            'registration_date' => 'date',
        ];
    }

    public function isRegistrationOpen(): bool
    {
        $today = now()->startOfDay();

        if ($this->registrationForm && ! $this->registrationForm->is_open) {
            return false;
        }

        if ($this->registration_start_date && $today->lt($this->registration_start_date->startOfDay())) {
            return false;
        }

        if ($this->registration_date && $today->gt($this->registration_date->startOfDay())) {
            return false;
        }

        return true;
    }

    public function getRegistrationStatusAttribute(): string
    {
        $today = now()->startOfDay();

        if ($this->registrationForm && ! $this->registrationForm->is_open) {
            return 'Registration Closed';
        }

        if ($this->registration_start_date && $today->lt($this->registration_start_date->startOfDay())) {
            return 'Opens ' . $this->registration_start_date->format('M d, Y');
        }

        if ($this->registration_date && $today->gt($this->registration_date->startOfDay())) {
            return 'Registration Closed';
        }

        return 'Open';
    }

    public function isFreeAdmission(): bool
    {
        return strtolower((string) $this->admission) !== 'paid';
    }

    public function getAdmissionLabelAttribute(): string
    {
        return $this->isFreeAdmission() ? 'Free Admission' : 'Paid Admission';
    }

    public function registrationForm(): HasOne
    {
        return $this->hasOne(EventRegistrationForm::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(EventTeam::class);
    }

    /**
     * Get all registered players for this event, grouped by teams and individuals.
     */
    public function getGroupedPlayers(): array
    {
        if (! $this->relationLoaded('teams')) {
            $this->load(['teams.members.registration']);
        } else {
            $this->teams->loadMissing(['members.registration']);
        }

        if (! $this->relationLoaded('registrations')) {
            $this->load('registrations');
        }

        $teams = [];
        $teamRegistrationIds = collect();
        $teamRegistrationRefs = collect();

        foreach ($this->teams as $team) {
            $members = [];
            foreach ($team->members as $member) {
                $regId = $member->event_registration_id;
                $ref = $member->registration_reference;

                if ($regId) {
                    $teamRegistrationIds->push($regId);
                }
                if ($ref) {
                    $teamRegistrationRefs->push(strtolower(trim($ref)));
                }

                $displayName = $member->member_name;
                if (empty($displayName) && $member->registration) {
                    $displayName = $member->registration->getAttendeeName();
                }
                if (empty($displayName)) {
                    $displayName = 'Player ' . $ref;
                }

                $members[] = [
                    'id' => $member->id,
                    'registration_id' => $regId,
                    'name' => $displayName,
                    'reference' => $ref,
                    'registered_at' => $member->created_at ? $member->created_at->format('M d, Y h:i A') : '—',
                    'has_team' => true,
                    'team_id' => $team->id,
                    'team_name' => $team->team_name,
                ];
            }

            $teams[] = [
                'id' => $team->id,
                'team_name' => $team->team_name,
                'team_reference' => $team->team_reference,
                'members_count' => count($members),
                'members' => $members,
            ];
        }

        $individualPlayers = [];
        foreach ($this->registrations as $registration) {
            $isAssignedToTeam = $teamRegistrationIds->contains($registration->id)
                || ($registration->registration_reference && $teamRegistrationRefs->contains(strtolower(trim($registration->registration_reference))));

            if (! $isAssignedToTeam) {
                $individualPlayers[] = [
                    'id' => $registration->id,
                    'registration_id' => $registration->id,
                    'name' => $registration->getAttendeeName(),
                    'reference' => $registration->registration_reference,
                    'registered_at' => $registration->created_at ? $registration->created_at->format('M d, Y h:i A') : '—',
                    'has_team' => false,
                    'team_id' => null,
                    'team_name' => null,
                ];
            }
        }

        $totalTeamMembers = collect($teams)->sum('members_count');
        $totalRegistered = $this->registrations->count();
        $totalPlayers = max($totalRegistered, $totalTeamMembers + count($individualPlayers));

        return [
            'event_id' => $this->id,
            'event_name' => $this->name,
            'event_date' => $this->event_date ? $this->event_date->format('M d, Y') : 'Date TBA',
            'is_open' => $this->isRegistrationOpen(),
            'total_players' => $totalPlayers,
            'total_teams' => count($teams),
            'individual_players_count' => count($individualPlayers),
            'teams' => $teams,
            'individual_players' => $individualPlayers,
        ];
    }
}
