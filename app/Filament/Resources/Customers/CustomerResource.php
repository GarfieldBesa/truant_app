<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers\Pages\CreateCustomer;
use App\Filament\Resources\Customers\Pages\EditCustomer;
use App\Filament\Resources\Customers\Pages\ListCustomers;
use App\Filament\Resources\Customers\Schemas\CustomerForm;
use App\Filament\Resources\Customers\Tables\CustomersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Schema as DbSchema;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Court Booking';

    protected static ?string $navigationLabel = 'Registered Customers';

    protected static ?string $pluralModelLabel = 'Registered Customers';

    protected static ?string $modelLabel = 'Customer';

    protected static ?int $navigationSort = 5;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        try {
            if (!DbSchema::hasTable('users')) {
                return null;
            }

            $count = User::where('role', 'customer')->count();

            return $count > 0 ? (string) $count : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function form(Schema $schema): Schema
    {
        return CustomerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomers::route('/'),
            'create' => CreateCustomer::route('/create'),
            'edit' => EditCustomer::route('/{record}/edit'),
        ];
    }
}
