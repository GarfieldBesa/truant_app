<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Event Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter event name')
                    ->columnSpanFull(),
                DatePicker::make('event_date')
                    ->label('Event Date')
                    ->required()
                    ->minDate(fn (string $operation) => $operation === 'create' ? now()->startOfDay() : null)
                    ->rules(fn (string $operation) => $operation === 'create' ? ['after_or_equal:today'] : [])
                    ->helperText('Event date cannot be in the past.'),
                DatePicker::make('registration_start_date')
                    ->label('Registration Start Date (Opens On)')
                    ->default(now()->startOfDay())
                    ->minDate(fn (string $operation) => $operation === 'create' ? now()->startOfDay() : null)
                    ->helperText('Date when registration opens for attendees.'),
                DatePicker::make('registration_date')
                    ->label('Registration Deadline (Closes On)')
                    ->required()
                    ->minDate(fn ($get, string $operation) => $operation === 'create' ? ($get('registration_start_date') ?: now()->startOfDay()) : null)
                    ->helperText('Last day attendees can submit their registration.'),
                FileUpload::make('banner')
                    ->label('Event Banner')
                    ->image()
                    ->disk('public')
                    ->directory('events/banners')
                    ->maxSize(5120)
                    ->columnSpanFull()
                    ->helperText('Upload a banner image for the event (PNG, JPG, WEBP up to 5MB).'),
                RichEditor::make('description')
                    ->label('Description')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Provide a rich formatted description for the event.'),
            ]);
    }
}
