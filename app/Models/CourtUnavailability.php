<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourtUnavailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_id',
        'date',
        'hour',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
            'hour' => 'integer',
        ];
    }

    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }

    public function isFullDay(): bool
    {
        return is_null($this->hour);
    }

    public function getFormattedHourAttribute(): string
    {
        if (is_null($this->hour)) {
            return 'Full Day';
        }

        $startPeriod = $this->hour < 12 ? 'AM' : 'PM';
        $displayStart = $this->hour % 12 === 0 ? 12 : $this->hour % 12;

        $endH = $this->hour + 1;
        $endPeriod = $endH < 12 || $endH === 24 ? 'AM' : 'PM';
        $displayEnd = $endH % 12 === 0 ? 12 : $endH % 12;

        return sprintf('%d:00 %s - %d:00 %s', $displayStart, $startPeriod, $displayEnd, $endPeriod);
    }
}
