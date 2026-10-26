<?php

namespace App\Filament\Resources\CourtUnavailabilities\Schemas;

use App\Models\CourtBooking;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CourtUnavailabilityForm
{
    public static function configure(Schema $schema): Schema
    {
        // 24 Hourly Slots Options
        $hourOptions = [];
        for ($h = 0; $h < 24; $h++) {
            $hourOptions[$h] = CourtBooking::formatHourRange($h, $h + 1);
        }

        return $schema
            ->components([
                Select::make('court_id')
                    ->label('Court')
                    ->relationship('court', 'name')
                    ->required()
                    ->helperText('Choose which court will be unavailable.'),
                DatePicker::make('date')
                    ->label('Date')
                    ->required()
                    ->helperText('Date of closure or blackout.'),
                Radio::make('blackout_scope')
                    ->label('Unavailability Scope')
                    ->options([
                        'full_day' => 'Entire Day (All 24 hours closed)',
                        'specific_hour' => 'Specific 1-Hour Time Slot',
                    ])
                    ->default('full_day')
                    ->live()
                    ->dehydrated(false)
                    ->afterStateHydrated(function ($set, $record) {
                        if ($record && !is_null($record->hour)) {
                            $set('blackout_scope', 'specific_hour');
                        } else {
                            $set('blackout_scope', 'full_day');
                        }
                    })
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state === 'full_day') {
                            $set('hour', null);
                        }
                    })
                    ->columnSpanFull(),
                Select::make('hour')
                    ->label('Specific Time Slot')
                    ->options($hourOptions)
                    ->visible(fn ($get) => $get('blackout_scope') === 'specific_hour')
                    ->required(fn ($get) => $get('blackout_scope') === 'specific_hour')
                    ->placeholder('Select 1-hour interval')
                    ->helperText('Select the specific hour interval when the court is closed.')
                    ->columnSpanFull(),
                TextInput::make('reason')
                    ->label('Reason for Closure (Shown to Customers)')
                    ->placeholder('e.g. Scheduled Floor Maintenance, Private Tournament, National Holiday')
                    ->columnSpanFull(),
            ]);
    }
}
