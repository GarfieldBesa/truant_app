<?php

namespace App\Filament\Resources\Courts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourtForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Court Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Pickleball Court'),
                Select::make('court_type')
                    ->label('Court Type')
                    ->options([
                        'pickleball' => 'Pickleball Court',
                        'basketball' => 'Basketball Court',
                    ])
                    ->required(),
                TextInput::make('default_slots_per_hour')
                    ->label('Slots Per Hour (Capacity)')
                    ->numeric()
                    ->default(4)
                    ->minValue(1)
                    ->maxValue(50)
                    ->required()
                    ->helperText('Configures the maximum customer reservation slots available per 1-hour interval (default: 4).'),
                TextInput::make('hourly_rate')
                    ->label('Hourly Rate (PHP)')
                    ->numeric()
                    ->prefix('₱')
                    ->placeholder('e.g. 350.00'),
                Toggle::make('is_active')
                    ->label('Active for Online Booking')
                    ->default(true)
                    ->helperText('If disabled, this court will not be visible on the public booking page.')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Court Description & Amenities')
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder('Describe court surface, lighting, seating, and features.'),
            ]);
    }
}
