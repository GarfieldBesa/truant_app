<?php

namespace App\Filament\Resources\CourtBookings\Tables;

use App\Models\CourtBooking;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class CourtBookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_code')
                    ->label('Ref Code')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('court.name')
                    ->label('Court')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->weight('bold')
                    ->description(function (CourtBooking $record): string {
                        $contact = $record->customer_contact;
                        if ($record->user_id && $record->user) {
                            $provider = !empty($record->user->google_id) ? 'Google User' : 'Registered User';
                            return "{$contact} • [{$provider}]";
                        }
                        return $contact;
                    }),
                TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('booking_date')
                    ->label('Date')
                    ->date('M d, Y')
                    ->sortable(),
                TextColumn::make('time_slot')
                    ->label('Time Slot')
                    ->badge()
                    ->color('primary')
                    ->getStateUsing(fn (CourtBooking $record): string => $record->time_slot),
                TextColumn::make('slots_count')
                    ->label('Slots')
                    ->badge()
                    ->color('gray')
                    ->alignCenter(),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('payment_mode')
                    ->label('Payment')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'cash_on_site' => 'Cash On Site',
                        'gcash' => 'GCash / E-Wallet',
                        'bank_transfer' => 'Bank Transfer',
                        default => $state ? ucfirst(str_replace('_', ' ', $state)) : 'Unselected',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'cash_on_site' => 'success',
                        'gcash' => 'info',
                        'bank_transfer' => 'primary',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'confirmed' => 'Confirmed',
                        'verified' => 'Email Verified',
                        'pending_verification' => 'Pending Verification',
                        'declined' => 'Declined',
                        'cancelled' => 'Cancelled',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'verified' => 'info',
                        'pending_verification' => 'warning',
                        'declined' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Booked On')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('booking_date', 'desc')
            ->filters([
                SelectFilter::make('court_id')
                    ->label('Court')
                    ->relationship('court', 'name'),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'confirmed' => 'Confirmed',
                        'verified' => 'Email Verified',
                        'pending_verification' => 'Pending Verification',
                        'declined' => 'Declined',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('payment_mode')
                    ->label('Payment Mode')
                    ->options([
                        'cash_on_site' => 'Cash on Site',
                        'gcash' => 'GCash / E-Wallet',
                        'bank_transfer' => 'Bank Transfer',
                    ]),
                Filter::make('booking_date')
                    ->form([
                        DatePicker::make('from')->label('From Date'),
                        DatePicker::make('until')->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('booking_date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('booking_date', '<=', $date));
                    }),
            ])
            ->actions([
                // 1. View Summary Modal
                Action::make('view_summary')
                    ->label('Summary')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->color('info')
                    ->modalHeading(fn (CourtBooking $record) => "Reservation Summary: #{$record->reference_code}")
                    ->modalContent(fn (CourtBooking $record) => new HtmlString('
                        <div style="font-family: inherit; font-size: 0.9rem; line-height: 1.6;">
                            <div style="background: rgba(56, 189, 248, 0.08); border: 1px solid rgba(56, 189, 248, 0.25); border-radius: 8px; padding: 14px 18px; margin-bottom: 16px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="color: #64748b; font-weight: 500;">Reference Code:</span>
                                    <strong style="color: #38bdf8; font-family: monospace; font-size: 1rem;">' . e($record->reference_code) . '</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="color: #64748b; font-weight: 500;">Status:</span>
                                    <strong style="text-transform: uppercase;">' . e($record->status_label) . '</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #64748b; font-weight: 500;">Court:</span>
                                    <strong>' . e($record->court->name ?? 'Court') . '</strong>
                                </div>
                            </div>

                            <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px;">
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <td style="padding: 8px 0; color: #94a3b8; width: 40%;">Reservation Date:</td>
                                    <td style="padding: 8px 0; font-weight: 600;">' . e($record->booking_date->format('l, F d, Y')) . '</td>
                                </tr>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <td style="padding: 8px 0; color: #94a3b8;">Time Slot:</td>
                                    <td style="padding: 8px 0; font-weight: 600; color: #38bdf8;">' . e($record->time_slot) . '</td>
                                </tr>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <td style="padding: 8px 0; color: #94a3b8;">Slots Reserved:</td>
                                    <td style="padding: 8px 0; font-weight: 600;">' . e($record->slots_count) . ' slot(s)</td>
                                </tr>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <td style="padding: 8px 0; color: #94a3b8;">Customer Name:</td>
                                    <td style="padding: 8px 0; font-weight: 600;">' . e($record->customer_name) . '</td>
                                </tr>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <td style="padding: 8px 0; color: #94a3b8;">Email Address:</td>
                                    <td style="padding: 8px 0; font-weight: 600;">' . e($record->customer_email) . '</td>
                                </tr>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <td style="padding: 8px 0; color: #94a3b8;">Contact Number:</td>
                                    <td style="padding: 8px 0; font-weight: 600;">' . e($record->customer_contact) . '</td>
                                </tr>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <td style="padding: 8px 0; color: #94a3b8;">Mode of Payment:</td>
                                    <td style="padding: 8px 0; font-weight: 600; color: #34d399;">' . e($record->payment_mode_label) . '</td>
                                </tr>
                                ' . ($record->payment_notes ? '
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <td style="padding: 8px 0; color: #94a3b8;">Payment Notes:</td>
                                    <td style="padding: 8px 0;">' . e($record->payment_notes) . '</td>
                                </tr>
                                ' : '') . '
                                ' . ($record->notes ? '
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <td style="padding: 8px 0; color: #94a3b8;">Customer Notes:</td>
                                    <td style="padding: 8px 0;">' . e($record->notes) . '</td>
                                </tr>
                                ' : '') . '
                                ' . ($record->decline_reason ? '
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <td style="padding: 8px 0; color: #ef4444;">Decline Reason:</td>
                                    <td style="padding: 8px 0; color: #f87171; font-weight: 600;">' . e($record->decline_reason) . '</td>
                                </tr>
                                ' : '') . '
                            </table>
                        </div>
                    '))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),

                // 2. Confirm Reservation Action
                Action::make('confirm_reservation')
                    ->label('Confirm')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (CourtBooking $record): bool => $record->status !== 'confirmed' && $record->status !== 'declined')
                    ->requiresConfirmation()
                    ->modalHeading('Confirm Court Reservation')
                    ->modalDescription(fn (CourtBooking $record): string => "Are you sure you want to approve and confirm reservation #{$record->reference_code} for {$record->customer_name}?")
                    ->action(function (CourtBooking $record): void {
                        $record->update(['status' => 'confirmed']);
                        Notification::make()
                            ->title('Reservation Confirmed')
                            ->body("Booking #{$record->reference_code} is now marked as confirmed.")
                            ->success()
                            ->send();
                    }),

                // 3. Decline Schedule Action (User explicit requirement)
                Action::make('decline_schedule')
                    ->label('Decline Schedule')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (CourtBooking $record): bool => $record->status !== 'declined')
                    ->requiresConfirmation()
                    ->modalHeading(fn (CourtBooking $record): string => "Decline Schedule for #{$record->reference_code}")
                    ->modalDescription('Declining this schedule will free up the court slot and log your decline reason.')
                    ->form([
                        Textarea::make('decline_reason')
                            ->label('Reason for Declining Schedule')
                            ->required()
                            ->rows(3)
                            ->placeholder('e.g. Schedule conflict with private tournament, maintenance required, or customer requested cancellation.'),
                    ])
                    ->action(function (CourtBooking $record, array $data): void {
                        $record->update([
                            'status' => 'declined',
                            'decline_reason' => $data['decline_reason'],
                        ]);

                        Notification::make()
                            ->title('Reservation Declined')
                            ->body("Booking #{$record->reference_code} has been declined. The court slot has been freed.")
                            ->danger()
                            ->send();
                    }),

                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ]);
    }
}
