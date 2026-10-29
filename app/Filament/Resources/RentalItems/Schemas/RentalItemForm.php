<?php

namespace App\Filament\Resources\RentalItems\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RentalItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Item Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Tournament Pickleball Paddle'),
                TextInput::make('rental_price')
                    ->label('Rental Price per Slot (PHP)')
                    ->numeric()
                    ->prefix('₱')
                    ->default(50.00)
                    ->required()
                    ->placeholder('50.00'),
                TextInput::make('total_stock')
                    ->label('Total Inventory Stock')
                    ->numeric()
                    ->default(10)
                    ->minValue(0)
                    ->required()
                    ->helperText('Total available quantity owned. Slot availability will deduct active rentals per hour.'),
                Toggle::make('is_active')
                    ->label('Available for Customer Rental')
                    ->default(true)
                    ->helperText('If turned off, this equipment will not appear as an option during booking.')
                    ->columnSpanFull(),
                FileUpload::make('picture')
                    ->label('Item Picture / Photo')
                    ->image()
                    ->disk('public')
                    ->directory('court-rentals')
                    ->maxSize(5120)
                    ->columnSpanFull()
                    ->helperText('Upload a high quality photo of the rental item (PNG, JPG, WEBP up to 5MB).'),
                Textarea::make('description')
                    ->label('Item Description & Specifications')
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder('Mention brand, specifications, grip size, or usage recommendations.'),
            ]);
    }
}
