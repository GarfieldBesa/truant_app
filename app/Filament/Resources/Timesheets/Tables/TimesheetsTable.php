<?php

namespace App\Filament\Resources\Timesheets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class TimesheetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.first_name')
                    ->label('Employee Name')
                    ->formatStateUsing(fn ($record) => "{$record->employee->first_name} {$record->employee->last_name}")
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('time_in')
                    ->time('g:i A')
                    ->sortable(),
                TextColumn::make('time_out')
                    ->time('g:i A')
                    ->sortable(),
                IconColumn::make('is_on_leave')
                    ->label('On Leave')
                    ->boolean(),
                IconColumn::make('has_meal_allowance')
                    ->label('Meal Allowance')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon(null)
                    ->trueColor('success'),
                TextColumn::make('deduction')
                    ->money('PHP')
                    ->sortable()
                    ->icon(fn ($record) => $record->deduction_description ? 'heroicon-o-information-circle' : null)
                    ->iconPosition('after')
                    ->tooltip(fn ($record) => $record->deduction_description),
                TextColumn::make('extra_income')
                    ->money('PHP')
                    ->sortable()
                    ->icon(fn ($record) => $record->extra_income_description ? 'heroicon-o-information-circle' : null)
                    ->iconPosition('after')
                    ->tooltip(fn ($record) => $record->extra_income_description),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->groups([
                Group::make('date')
                    ->label('Date')
                    ->date(),
            ])
            ->defaultGroup('date')
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
