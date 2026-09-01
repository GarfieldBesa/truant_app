<?php

namespace App\Filament\Resources\Positions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(table: 'positions', ignoreRecord: true),
                TextInput::make('base_rate')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->prefix('₱'),
                TextInput::make('overtime_rate')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->prefix('₱'),
                TextInput::make('sss')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->prefix('₱'),
                TextInput::make('philhealth')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->prefix('₱'),
                TextInput::make('pag_ibig')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->prefix('₱'),
            ]);
    }
}
