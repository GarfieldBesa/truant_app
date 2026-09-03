<?php

namespace App\Filament\Resources\CashAdvances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class CashAdvancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.first_name')
                    ->label('Employee')
                    ->formatStateUsing(fn ($record) => "{$record->employee->first_name} {$record->employee->last_name}")
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('amount')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('reason')
                    ->limit(50),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'declined' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Submitted Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('approve')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $employee = $record->employee;
                        $now = now();
                        $date = $now->toDateString();
                        
                        $day = $now->day;
                        $cutoffStart = $day <= 15 ? 1 : 16;
                        $cutoffEnd = $day <= 15 ? 15 : $now->daysInMonth;
                        
                        $startDate = $now->copy()->setDay($cutoffStart)->toDateString();
                        $endDate = $now->copy()->setDay($cutoffEnd)->toDateString();

                        $timesheet = \App\Models\Timesheet::where('employee_id', $employee->id)
                            ->where('date', $date)
                            ->where(function($q) {
                                $q->whereNotNull('time_in')->orWhereNotNull('time_out');
                            })->first();

                        if (!$timesheet) {
                            $timesheet = \App\Models\Timesheet::where('employee_id', $employee->id)
                                ->whereBetween('date', [$startDate, $endDate])
                                ->where(function($q) {
                                    $q->whereNotNull('time_in')->orWhereNotNull('time_out');
                                })
                                ->orderByRaw('ABS(DATEDIFF(date, ?))', [$date])
                                ->first();
                        }

                        if (!$timesheet) {
                            $timesheet = \App\Models\Timesheet::create([
                                'employee_id' => $employee->id,
                                'date' => $date,
                            ]);
                        }

                        $timesheet->deduction += $record->amount;
                        if ($timesheet->deduction_description) {
                            $timesheet->deduction_description .= ', Cash Advance';
                        } else {
                            $timesheet->deduction_description = 'Cash Advance';
                        }
                        $timesheet->save();

                        $record->update([
                            'status' => 'approved',
                            'approved_at' => $now,
                            'applied_timesheet_id' => $timesheet->id,
                        ]);

                        Notification::make()->title('Approved')->success()->send();
                    }),

                Action::make('decline')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'declined',
                        ]);
                        Notification::make()->title('Declined')->success()->send();
                    }),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
