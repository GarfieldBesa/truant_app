<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\CheckboxList;
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
                CheckboxList::make('roles')
                    ->label('System Access Permissions')
                    ->options([
                        'admin' => 'Administrator Access (Full Admin Dashboard, Payroll & Approvals)',
                        'timesheet_portal' => 'Timesheet Portal Access (Time In / Time Out, Leave & Cash Advance Requests)',
                    ])
                    ->descriptions([
                        'admin' => 'Grants full administrator privileges to log in to the admin panel, manage employees, payroll, and review requests.',
                        'timesheet_portal' => 'Allows this employee to log in and use the standalone Timesheet Portal.',
                    ])
                    ->columns(1)
                    ->columnSpanFull()
                    ->helperText('Select the system portals and access permissions granted to this employee.'),
                Select::make('locations')
                    ->label('Assigned Locations')
                    ->relationship('locations', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->helperText('Choose one or more authorized locations for this employee. Pulled from IP Configuration.')
                    ->columnSpanFull(),
            ]);
    }
}
