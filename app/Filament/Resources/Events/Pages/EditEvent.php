<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('customize_form')
                ->label('Customize Form')
                ->icon(Heroicon::OutlinedPencilSquare)
                ->color('primary')
                ->url(fn (): string => EventResource::getUrl('form', ['record' => $this->record])),
            Action::make('view_form')
                ->label('View Form')
                ->icon(Heroicon::OutlinedEye)
                ->color('info')
                ->url(fn (): string => EventResource::getUrl('view-form', ['record' => $this->record])),
            DeleteAction::make(),
        ];
    }
}
