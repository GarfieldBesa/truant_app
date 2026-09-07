<?php

namespace App\Filament\Resources\Events\Tables;

use App\Filament\Resources\Events\EventResource;
use App\Models\Event;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('banner')
                    ->label('Banner')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl('/placeholder-event.png')
                    ->width(60)
                    ->height(40),
                TextColumn::make('name')
                    ->label('Event Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('event_date')
                    ->label('Event Date')
                    ->date('M d, Y')
                    ->sortable(),
                TextColumn::make('registration_period')
                    ->label('Registration Period')
                    ->getStateUsing(function (Event $record): string {
                        $start = $record->registration_start_date ? $record->registration_start_date->format('M d, Y') : 'Immediately';
                        $end = $record->registration_date ? $record->registration_date->format('M d, Y') : 'TBD';
                        return "{$start} — {$end}";
                    }),
                TextColumn::make('registration_status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(fn (Event $record): string => $record->registration_status)
                    ->color(fn (string $state): string => match ($state) {
                        'Open' => 'success',
                        'Registration Closed' => 'danger',
                        default => 'warning',
                    }),
                TextColumn::make('admission')
                    ->label('Admission')
                    ->badge()
                    ->getStateUsing(fn (Event $record): string => $record->admission_label)
                    ->color(fn (string $state): string => match ($state) {
                        'Free Admission' => 'success',
                        'Paid Admission' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('registrations_count')
                    ->label('Registered')
                    ->counts('registrations')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('registrations')
                        ->label('Registered People')
                        ->icon(Heroicon::OutlinedUsers)
                        ->color('success')
                        ->tooltip('View registered attendees, dynamic columns, and printable report')
                        ->url(fn (Event $record): string => EventResource::getUrl('registrations', ['record' => $record])),
                    Action::make('customize_form')
                        ->label('Customize Form')
                        ->icon(Heroicon::OutlinedPencilSquare)
                        ->color('primary')
                        ->tooltip('Configure dynamic registration form and consent agreement')
                        ->url(fn (Event $record): string => EventResource::getUrl('form', ['record' => $record])),
                    Action::make('view_form')
                        ->label('View Form')
                        ->icon(Heroicon::OutlinedEye)
                        ->color('info')
                        ->tooltip('Preview the actual created registration form')
                        ->url(fn (Event $record): string => EventResource::getUrl('view-form', ['record' => $record])),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
                ->tooltip('Event Actions'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
