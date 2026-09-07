<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EventTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'team_name',
        'team_reference',
    ];

    protected static function booted(): void
    {
        static::creating(function (EventTeam $team) {
            if (empty($team->team_reference)) {
                $team->team_reference = 'TEAM-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
            }
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(EventTeamMember::class, 'event_team_id');
    }
}
