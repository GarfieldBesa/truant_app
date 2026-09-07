<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventTeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_team_id',
        'event_registration_id',
        'registration_reference',
        'member_name',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(EventTeam::class, 'event_team_id');
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }
}
