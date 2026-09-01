<?php

namespace App\Filament\Resources\Positions\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuditLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'auditLogs';

    protected static ?string $title = 'Audit Logs / History';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('action')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date & Time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Modified By')
                    ->placeholder('System')
                    ->searchable(),
                TextColumn::make('action')
                    ->label('Action')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('changes')
                    ->label('Changes')
                    ->getStateUsing(function ($record): string {
                        $changes = $record->changes;
                        if (empty($changes) || !is_array($changes)) {
                            return 'No direct property changes';
                        }
                        
                        $output = [];
                        foreach ($changes as $key => $values) {
                            $oldVal = is_null($values['old']) ? 'None' : $values['old'];
                            $newVal = is_null($values['new']) ? 'None' : $values['new'];
                            
                            // Format field names nicely
                            $field = ucwords(str_replace('_', ' ', $key));
                            
                            $output[] = "{$field}: {$oldVal} ➔ {$newVal}";
                        }
                        
                        return implode(', ', $output);
                    })
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Read-only
            ])
            ->actions([
                // Read-only
            ])
            ->bulkActions([
                // Read-only
            ]);
    }
}
