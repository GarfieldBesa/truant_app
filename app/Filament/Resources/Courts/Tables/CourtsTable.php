<?php

namespace App\Filament\Resources\Courts\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CourtsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Court Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('court_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pickleball' => 'Pickleball',
                        'basketball' => 'Basketball',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pickleball' => 'info',
                        'basketball' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('default_slots_per_hour')
                    ->label('Slots / Hour')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('hourly_rate')
                    ->label('Hourly Rate')
                    ->money('PHP')
                    ->placeholder('Free')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }
}
