<?php

namespace App\Filament\Resources\RentalItems\Pages;

use App\Filament\Resources\RentalItems\RentalItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRentalItem extends EditRecord
{
    protected static string $resource = RentalItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
