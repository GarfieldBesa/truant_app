<?php

namespace App\Filament\Resources\CashAdvances\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CashAdvanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->relationship('employee', 'last_name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->preload()
                    ->required(),
                TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->prefix('₱')
                    ->minValue(1),
                Textarea::make('reason')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }
}
