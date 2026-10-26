<?php

namespace App\Filament\Resources\CourtUnavailabilities;

use App\Filament\Resources\CourtUnavailabilities\Pages\CreateCourtUnavailability;
use App\Filament\Resources\CourtUnavailabilities\Pages\EditCourtUnavailability;
use App\Filament\Resources\CourtUnavailabilities\Pages\ListCourtUnavailabilities;
use App\Filament\Resources\CourtUnavailabilities\Schemas\CourtUnavailabilityForm;
use App\Filament\Resources\CourtUnavailabilities\Tables\CourtUnavailabilitiesTable;
use App\Models\CourtUnavailability;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourtUnavailabilityResource extends Resource
{
    protected static ?string $model = CourtUnavailability::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Court Booking';

    protected static ?string $navigationLabel = 'Court Availability & Blackouts';

    protected static ?string $pluralModelLabel = 'Court Unavailabilities';

    protected static ?string $modelLabel = 'Court Unavailability';

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    public static function form(Schema $schema): Schema
    {
        return CourtUnavailabilityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourtUnavailabilitiesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourtUnavailabilities::route('/'),
            'create' => CreateCourtUnavailability::route('/create'),
            'edit' => EditCourtUnavailability::route('/{record}/edit'),
        ];
    }
}
