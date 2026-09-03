<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('position_id')
                    ->relationship('position', 'name')
                    ->required(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                DatePicker::make('birthdate')
                    ->required(),
                TextInput::make('mobile_number')
                    ->required(),
                TextInput::make('username')
                    ->required()
                    ->unique(table: 'employees', ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Select::make('role')
                    ->label('Portal Role / Access')
                    ->options([
                        'employee' => 'Standard Employee (No Portal Access)',
                        'timesheet_portal' => 'Timesheet Portal User (Timesheet Entry Access)',
                    ])
                    ->default('employee')
                    ->required()
                    ->helperText('Assigning Timesheet Portal User allows this employee to log in and access the timesheet portal.'),
            ]);
    }
}
