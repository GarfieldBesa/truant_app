<?php

namespace App\Filament\Resources\Events\RegisteredTeams;

use App\Filament\Resources\Events\RegisteredTeams\Pages\ListRegisteredTeams;
use App\Filament\Resources\Events\RegisteredTeams\Tables\RegisteredTeamsTable;
use App\Models\EventTeam;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RegisteredTeamResource extends Resource
{
    protected static ?string $model = EventTeam::class;

    protected static ?string $navigationParentItem = 'Events';

    protected static ?string $navigationLabel = 'Registered Teams';

    protected static ?string $pluralModelLabel = 'Registered Teams';

    protected static ?string $modelLabel = 'Registered Team';

    protected static ?int $navigationSort = 2;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    public static function table(Table $table): Table
    {
        return RegisteredTeamsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRegisteredTeams::route('/'),
        ];
    }
}
