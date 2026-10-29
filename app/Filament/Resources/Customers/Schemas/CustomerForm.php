<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email', ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->label('Contact / Mobile Number')
                    ->tel()
                    ->maxLength(50)
                    ->placeholder('e.g. 0917-123-4567'),
                Select::make('role')
                    ->label('Account Role')
                    ->options([
                        'customer' => 'Customer (Portal & Booking Access)',
                        'admin' => 'Administrator (Full Admin Panel Access)',
                    ])
                    ->default('customer')
                    ->required(),
                TextInput::make('google_id')
                    ->label('Google OAuth ID')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Not linked to Google'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->helperText('Leave empty to preserve existing password. Optional if logging in via Google OAuth.'),
            ]);
    }
}
