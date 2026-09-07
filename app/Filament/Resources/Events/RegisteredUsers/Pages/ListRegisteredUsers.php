<?php

namespace App\Filament\Resources\Events\RegisteredUsers\Pages;

use App\Filament\Resources\Events\RegisteredUsers\RegisteredUserResource;
use Filament\Resources\Pages\ListRecords;

class ListRegisteredUsers extends ListRecords
{
    protected static string $resource = RegisteredUserResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
