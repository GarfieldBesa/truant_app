<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistrationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'description',
        'banner',
        'registration_start_date',
        'registration_end_date',
        'is_open',
        'consent_title',
        'consent_body',
        'consent_checkbox_label',
        'fields',
    ];

    protected function casts(): array
    {
        return [
            'registration_start_date' => 'date',
            'registration_end_date' => 'date',
            'is_open' => 'boolean',
            'fields' => 'array',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
