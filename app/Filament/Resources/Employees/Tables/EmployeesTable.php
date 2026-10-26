<?php

namespace App\Filament\Resources\Employees\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('position.name')
                    ->label('Position')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('birthdate')
                    ->date()
                    ->sortable(),
                TextColumn::make('mobile_number')
                    ->searchable(),
                TextColumn::make('username')
                    ->searchable(),
                TextColumn::make('roles')
                    ->label('Access Permissions')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'timesheet_portal' => 'Timesheet Portal',
                        default => $state ? ucfirst(str_replace('_', ' ', $state)) : 'No Access',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'timesheet_portal' => 'success',
                        default => 'info',
                    })
                    ->placeholder('No Access')
                    ->sortable(),
                TextColumn::make('locations.name')
                    ->label('Locations')
                    ->badge()
                    ->color('warning')
                    ->placeholder('None')
                    ->separator(', '),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
