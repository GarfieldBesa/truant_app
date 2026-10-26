<?php

namespace App\Filament\Resources\CourtUnavailabilities\Tables;

use App\Models\CourtUnavailability;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CourtUnavailabilitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('court.name')
                    ->label('Court')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date('M d, Y')
                    ->sortable(),
                TextColumn::make('hour')
                    ->label('Unavailable Time Slot')
                    ->getStateUsing(fn (CourtUnavailability $record): string => $record->formatted_hour)
                    ->badge()
                    ->color(fn (CourtUnavailability $record): string => $record->isFullDay() ? 'danger' : 'warning'),
                TextColumn::make('reason')
                    ->label('Reason')
                    ->placeholder('Unspecified')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('court_id')
                    ->label('Court')
                    ->relationship('court', 'name'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
