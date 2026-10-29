<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Determine if the user can access the panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin' || str_contains(strtolower($this->email ?? ''), 'admin');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id',
        'avatar',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function courtBookings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourtBooking::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || str_contains(strtolower($this->email ?? ''), 'admin');
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return $this->avatar;
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4f46e5&color=fff&bold=true';
    }
}
