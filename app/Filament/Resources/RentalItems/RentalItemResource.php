<?php

namespace App\Filament\Resources\RentalItems;

use App\Filament\Resources\RentalItems\Pages\CreateRentalItem;
use App\Filament\Resources\RentalItems\Pages\EditRentalItem;
use App\Filament\Resources\RentalItems\Pages\ListRentalItems;
use App\Filament\Resources\RentalItems\Schemas\RentalItemForm;
use App\Filament\Resources\RentalItems\Tables\RentalItemsTable;
use App\Models\RentalItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RentalItemResource extends Resource
{
    protected static ?string $model = RentalItem::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Court Booking';

    protected static ?string $navigationLabel = 'Rental Items & Gear';

    protected static ?string $pluralModelLabel = 'Rental Items';

    protected static ?string $modelLabel = 'Rental Item';

    protected static ?int $navigationSort = 4;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return RentalItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RentalItemsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRentalItems::route('/'),
            'create' => CreateRentalItem::route('/create'),
            'edit' => EditRentalItem::route('/{record}/edit'),
        ];
    }
}
