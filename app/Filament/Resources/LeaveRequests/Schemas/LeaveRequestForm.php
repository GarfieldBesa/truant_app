<?php

namespace App\Filament\Resources\LeaveRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LeaveRequestForm
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
                Select::make('leave_type')
                    ->options([
                        'Vacation Leave' => 'Vacation Leave',
                        'Sick Leave' => 'Sick Leave',
                        'Emergency Leave' => 'Emergency Leave',
                        'Personal Leave' => 'Personal Leave',
                    ])
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'declined' => 'Declined',
                    ])
                    ->default('pending')
                    ->required(),
                Textarea::make('reason')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }
}
