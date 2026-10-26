<?php

namespace App\Filament\Resources\Courts;

use App\Filament\Resources\Courts\Pages\EditCourt;
use App\Filament\Resources\Courts\Pages\ListCourts;
use App\Filament\Resources\Courts\Schemas\CourtForm;
use App\Filament\Resources\Courts\Tables\CourtsTable;
use App\Models\Court;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourtResource extends Resource
{
    protected static ?string $model = Court::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Court Booking';

    protected static ?string $navigationLabel = 'Courts & Capacity';

    protected static ?string $pluralModelLabel = 'Courts';

    protected static ?string $modelLabel = 'Court';

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CourtForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourtsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourts::route('/'),
            'edit' => EditCourt::route('/{record}/edit'),
        ];
    }
}
