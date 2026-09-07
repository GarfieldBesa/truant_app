<?php

namespace App\Filament\Resources\LeaveRequests\Tables;

use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeaveRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.first_name')
                    ->label('Employee')
                    ->formatStateUsing(fn ($record) => "{$record->employee->first_name} {$record->employee->last_name}")
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('leave_type')
                    ->label('Type')
                    ->badge()
                    ->color('info'),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('reason')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->reason),
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
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Leave Request')
                    ->modalDescription(fn ($record) => "Approve leave for {$record->employee->first_name} {$record->employee->last_name} from " . Carbon::parse($record->start_date)->format('M d, Y') . " to " . Carbon::parse($record->end_date)->format('M d, Y') . "? Timesheets for these dates will be automatically marked as On Leave.")
                    ->action(function ($record) {
                        $record->status = 'approved';
                        $record->approved_at = Carbon::now('Asia/Manila');
                        $record->save();

                        // Automatically update / create timesheets for the approved date range
                        $current = Carbon::parse($record->start_date);
                        $end = Carbon::parse($record->end_date);
                        while ($current->lte($end)) {
                            $ts = Timesheet::firstOrNew([
                                'employee_id' => $record->employee_id,
                                'date' => $current->toDateString(),
                            ]);
                            $ts->is_on_leave = true;
                            $ts->save();
                            $current->addDay();
                        }

                        Notification::make()
                            ->title('Leave Request Approved')
                            ->body("Leave approved for {$record->employee->first_name} {$record->employee->last_name}. Timesheets updated.")
                            ->success()
                            ->send();
                    }),

                Action::make('decline')
                    ->label('Decline')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->status = 'declined';
                        $record->save();

                        Notification::make()
                            ->title('Leave Request Declined')
                            ->danger()
                            ->send();
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
