<?php

namespace App\Filament\Resources\Events\RegisteredUsers;

use App\Filament\Resources\Events\RegisteredUsers\Pages\ListRegisteredUsers;
use App\Filament\Resources\Events\RegisteredUsers\Tables\RegisteredUsersTable;
use App\Models\EventRegistration;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RegisteredUserResource extends Resource
{
    protected static ?string $model = EventRegistration::class;

    protected static ?string $navigationParentItem = 'Events';

    protected static ?string $navigationLabel = 'Registered Users';

    protected static ?string $pluralModelLabel = 'Registered Users';

    protected static ?string $modelLabel = 'Registered User';

    protected static ?int $navigationSort = 3;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('id', function ($query) {
                $query->selectRaw('MIN(id)')
                    ->from('event_registrations')
                    ->groupBy('registration_reference');
            });
    }

    public static function table(Table $table): Table
    {
        return RegisteredUsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRegisteredUsers::route('/'),
        ];
    }
}
