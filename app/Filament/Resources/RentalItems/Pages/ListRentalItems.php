<?php

namespace App\Filament\Resources\RentalItems\Pages;

use App\Filament\Resources\RentalItems\RentalItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRentalItems extends ListRecords
{
    protected static string $resource = RentalItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
