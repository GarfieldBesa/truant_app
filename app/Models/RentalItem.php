<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RentalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'picture',
        'description',
        'rental_price',
        'total_stock',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'rental_price' => 'decimal:2',
            'total_stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (RentalItem $item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->name);
            }
        });
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(CourtBookingRental::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getPictureUrlAttribute(): ?string
    {
        if (empty($this->picture)) {
            return null;
        }

        if (str_starts_with($this->picture, 'http://') || str_starts_with($this->picture, 'https://')) {
            return $this->picture;
        }

        return asset('storage/' . ltrim($this->picture, '/'));
    }

    /**
     * Compute available stock for this item for a specific date and hour slot.
     */
    public function getAvailableStockForSlot(string $date, int $hour): int
    {
        $cutoffTime = now()->subMinutes(30);

        $rentedCount = (int) CourtBookingRental::where('rental_item_id', $this->id)
            ->whereHas('booking', function ($query) use ($date, $hour, $cutoffTime) {
                $query->whereDate('booking_date', $date)
                    ->where('start_hour', $hour)
                    ->where(function ($q) use ($cutoffTime) {
                        $q->whereIn('status', ['confirmed', 'verified'])
                            ->orWhere(function ($sub) use ($cutoffTime) {
                                $sub->where('status', 'pending_verification')
                                    ->where('created_at', '>=', $cutoffTime);
                            });
                    });
            })
            ->sum('quantity');

        return max(0, $this->total_stock - $rentedCount);
    }
}
