<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourtBookingRental extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_booking_id',
        'rental_item_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(CourtBooking::class, 'court_booking_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(RentalItem::class, 'rental_item_id');
    }
}
