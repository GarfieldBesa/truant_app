<?php

namespace App\Filament\Resources\Customers\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('courtBookings'))
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->circular()
                    ->defaultImageUrl(fn (User $record): string => $record->avatar_url),
                TextColumn::make('name')
                    ->label('Customer Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('phone_number')
                    ->label('Contact')
                    ->searchable()
                    ->default('—'),
                TextColumn::make('auth_provider')
                    ->label('Sign-in Method')
                    ->badge()
                    ->state(fn (User $record): string => !empty($record->google_id) ? 'Google OAuth' : 'Email & Password')
                    ->color(fn (User $record): string => !empty($record->google_id) ? 'warning' : 'gray'),
                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->colors([
                        'success' => 'customer',
                        'primary' => 'admin',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('court_bookings_count')
                    ->label('Total Bookings')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Registered On')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('User Role')
                    ->options([
                        'customer' => 'Customers',
                        'admin' => 'Administrators',
                    ]),
                SelectFilter::make('provider')
                    ->label('Sign-In Method')
                    ->options([
                        'google' => 'Google Sign-In',
                        'email' => 'Email / Password',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (($data['value'] ?? null) === 'google') {
                            return $query->whereNotNull('google_id');
                        }
                        if (($data['value'] ?? null) === 'email') {
                            return $query->whereNull('google_id');
                        }
                        return $query;
                    }),
            ])
            ->actions([
                Action::make('view_bookings')
                    ->label('Bookings')
                    ->icon('heroicon-o-ticket')
                    ->color('info')
                    ->modalHeading(fn (User $record): string => "Bookings History — {$record->name}")
                    ->modalContent(function (User $record): HtmlString {
                        $bookings = $record->courtBookings()->latest('booking_date')->get();
                        if ($bookings->isEmpty()) {
                            return new HtmlString('<p class="text-sm text-gray-500 py-4 text-center">No court reservations recorded yet for this user.</p>');
                        }

                        $rows = '';
                        foreach ($bookings as $b) {
                            $badgeColor = match ($b->status) {
                                'verified' => 'background:#dcfce7;color:#166534;',
                                'confirmed' => 'background:#e0e7ff;color:#3730a3;',
                                'cancelled' => 'background:#fee2e2;color:#991b1b;',
                                default => 'background:#fef9c3;color:#854d0e;',
                            };

                            $rows .= "
                                <tr style='border-bottom: 1px solid #e5e7eb;'>
                                    <td style='padding: 8px 12px; font-family: monospace; font-weight: bold;'>{$b->reference_code}</td>
                                    <td style='padding: 8px 12px;'>{$b->booking_date->format('M d, Y')}</td>
                                    <td style='padding: 8px 12px;'>{$b->time_slot}</td>
                                    <td style='padding: 8px 12px;'><span style='display:inline-block;padding:2px 8px;border-radius:9999px;font-size:12px;font-weight:600;{$badgeColor}'>" . ucfirst(str_replace('_', ' ', $b->status)) . "</span></td>
                                    <td style='padding: 8px 12px; font-weight: bold;'>₱" . number_format($b->total_amount, 2) . "</td>
                                </tr>
                            ";
                        }

                        $html = "
                            <div style='overflow-x:auto; margin-top: 10px;'>
                                <table style='width: 100%; text-align: left; font-size: 13px; border-collapse: collapse;'>
                                    <thead>
                                        <tr style='background: #f9fafb; border-bottom: 2px solid #e5e7eb;'>
                                            <th style='padding: 8px 12px;'>Ref Code</th>
                                            <th style='padding: 8px 12px;'>Date</th>
                                            <th style='padding: 8px 12px;'>Time Slot</th>
                                            <th style='padding: 8px 12px;'>Status</th>
                                            <th style='padding: 8px 12px;'>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$rows}
                                    </tbody>
                                </table>
                            </div>
                        ";

                        return new HtmlString($html);
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
