<?php

namespace App\Filament\Resources\Events\RegisteredUsers\Tables;

use App\Models\EventRegistration;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RegisteredUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('attendee_name')
                    ->label('Attendee Name')
                    ->getStateUsing(fn (EventRegistration $record): string => $record->getAttendeeName())
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        $needle = '%' . strtolower(trim($search)) . '%';
                        return $query->where(function ($q) use ($needle) {
                            $q->whereRaw('LOWER(data) LIKE ?', [$needle])
                              ->orWhereRaw('LOWER(registration_reference) LIKE ?', [$needle]);
                        });
                    })
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('registration_reference')
                    ->label('Reference Number (Ref#)')
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->copyable()
                    ->copyMessage('Reference number copied to clipboard'),

                TextColumn::make('events_count')
                    ->label('Events Registered')
                    ->badge()
                    ->color('info')
                    ->getStateUsing(fn (EventRegistration $record): string => $record->getAllEventsForReference()->count() . ' Events'),

                TextColumn::make('teams_count')
                    ->label('Teams Joined')
                    ->badge()
                    ->color('success')
                    ->getStateUsing(fn (EventRegistration $record): string => $record->getAllTeamsForReference()->count() . ' Teams'),

                TextColumn::make('created_at')
                    ->label('Date of Registration')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->recordAction('view_details')
            ->recordActions([
                ActionGroup::make([
                    Action::make('view_details')
                        ->label('View All Info')
                        ->icon(Heroicon::OutlinedEye)
                        ->color('primary')
                        ->modalHeading(fn (EventRegistration $record) => "Registered User: {$record->getAttendeeName()}")
                        ->modalDescription(fn (EventRegistration $record) => "Reference: {$record->registration_reference} • Initial registration on {$record->created_at?->format('M d, Y')}")
                        ->modalWidth('5xl')
                        ->modalContent(fn (EventRegistration $record) => view('filament.resources.events.registered-users.details-modal', ['record' => $record]))
                        ->modalSubmitAction(false),

                    DeleteAction::make()
                        ->label('Delete Record')
                        ->modalHeading('Delete Registered User Record')
                        ->modalDescription('Are you sure you want to delete this user registration record? Associated registrations for other events will remain unaffected.')
                        ->successNotificationTitle('User registration record deleted'),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
