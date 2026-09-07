<?php

namespace App\Filament\Resources\Events\RegisteredTeams\Pages;

use App\Filament\Resources\Events\RegisteredTeams\RegisteredTeamResource;
use Filament\Resources\Pages\ListRecords;

class ListRegisteredTeams extends ListRecords
{
    protected static string $resource = RegisteredTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
