<?php

namespace App\Filament\Resources\CourtBookings;

use App\Filament\Resources\CourtBookings\Pages\CreateCourtBooking;
use App\Filament\Resources\CourtBookings\Pages\EditCourtBooking;
use App\Filament\Resources\CourtBookings\Pages\ListCourtBookings;
use App\Filament\Resources\CourtBookings\Schemas\CourtBookingForm;
use App\Filament\Resources\CourtBookings\Tables\CourtBookingsTable;
use App\Models\CourtBooking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Schema as DbSchema;

class CourtBookingResource extends Resource
{
    protected static ?string $model = CourtBooking::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Court Booking';

    protected static ?string $navigationLabel = 'Reservations';

    protected static ?string $pluralModelLabel = 'Court Reservations';

    protected static ?string $modelLabel = 'Court Reservation';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static ?string $recordTitleAttribute = 'reference_code';

    public static function getNavigationBadge(): ?string
    {
        try {
            if (!DbSchema::hasTable('court_bookings')) {
                return null;
            }

            $count = CourtBooking::whereIn('status', ['pending_verification', 'verified'])->count();

            return $count > 0 ? (string) $count : null;
        } catch (\Throwable) {
            return null;
        }
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return CourtBookingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourtBookingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourtBookings::route('/'),
            'create' => CreateCourtBooking::route('/create'),
            'edit' => EditCourtBooking::route('/{record}/edit'),
        ];
    }
}
