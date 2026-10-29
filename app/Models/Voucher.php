<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'discount_type',
        'discount_value',
        'min_spend',
        'max_discount',
        'usage_limit',
        'times_used',
        'usage_limit_per_user',
        'is_active',
        'starts_at',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_spend' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'times_used' => 'integer',
        'usage_limit_per_user' => 'integer',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Scope for active vouchers.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Set code to uppercase automatically.
     */
    public function setCodeAttribute(string $value): void
    {
        $this->attributes['code'] = strtoupper(trim($value));
    }

    /**
     * Relationship to court bookings.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(CourtBooking::class);
    }

    /**
     * Relationship to creator user.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Validate voucher usability for a specific subtotal and user.
     */
    public function validateUsability(?User $user, float $subtotal): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'This voucher is currently inactive or disabled.'];
        }

        $now = Carbon::now('Asia/Manila');

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return ['valid' => false, 'message' => 'This voucher is not yet active.'];
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return ['valid' => false, 'message' => 'This voucher has already expired.'];
        }

        if ($this->usage_limit !== null && $this->times_used >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'This voucher has reached its redemption limit.'];
        }

        if ($this->min_spend !== null && $subtotal < (float) $this->min_spend) {
            return [
                'valid' => false,
                'message' => 'A minimum booking subtotal of ₱' . number_format($this->min_spend, 2) . ' is required to use this voucher.',
            ];
        }

        if ($user && $this->usage_limit_per_user > 0) {
            $userUsage = CourtBooking::where('voucher_id', $this->id)
                ->where('user_id', $user->id)
                ->whereIn('status', ['verified', 'confirmed'])
                ->count();

            if ($userUsage >= $this->usage_limit_per_user) {
                return ['valid' => false, 'message' => 'You have already redeemed this voucher the maximum allowed times.'];
            }
        }

        return ['valid' => true, 'message' => 'Voucher applied successfully!'];
    }

    /**
     * Compute discount amount given a subtotal.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal <= 0) {
            return 0.00;
        }

        if ($this->discount_type === 'percent') {
            $raw = round($subtotal * ((float) $this->discount_value / 100), 2);
            if ($this->max_discount !== null && $raw > (float) $this->max_discount) {
                $raw = (float) $this->max_discount;
            }
            return min($subtotal, $raw);
        }

        return min($subtotal, (float) $this->discount_value);
    }
}
