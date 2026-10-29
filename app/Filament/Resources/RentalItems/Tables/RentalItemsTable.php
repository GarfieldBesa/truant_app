<?php

namespace App\Filament\Resources\RentalItems\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RentalItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('picture')
                    ->label('Photo')
                    ->circular()
                    ->disk('public')
                    ->defaultImageUrl('https://images.unsplash.com/photo-1599474924187-334a4ae5bd3c?auto=format&fit=crop&w=150&q=80'),
                TextColumn::make('name')
                    ->label('Item Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('rental_price')
                    ->label('Rental Price')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('total_stock')
                    ->label('Inventory Stock')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'success' : 'danger')
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
                DeleteAction::make(),
            ]);
    }
}
