<?php

namespace App\Filament\Resources\Timesheets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TimesheetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->relationship('employee', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                TimePicker::make('time_in'),
                TimePicker::make('time_out'),
                Toggle::make('is_on_leave')
                    ->required(),
                Toggle::make('force_meal_allowance')
                    ->required(),
                TextInput::make('deduction')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('deduction_description'),
                TextInput::make('extra_income')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('extra_income_description'),
            ]);
    }
}
