<?php

namespace App\Filament\Resources\Vouchers\Tables;

use App\Models\Voucher;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class VouchersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Secret Code')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Description')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('discount_value')
                    ->label('Discount')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(function (Voucher $record): string {
                        return $record->discount_type === 'percent'
                            ? "{$record->discount_value}% OFF"
                            : "₱" . number_format($record->discount_value, 2) . " OFF";
                    }),
                TextColumn::make('min_spend')
                    ->label('Min Spend')
                    ->money('PHP')
                    ->default('—')
                    ->sortable(),
                TextColumn::make('times_used')
                    ->label('Redemptions')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(function (Voucher $record): string {
                        $limit = $record->usage_limit !== null ? $record->usage_limit : '∞';
                        return "{$record->times_used} / {$limit}";
                    })
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->label('Expires On')
                    ->dateTime('M d, Y H:i')
                    ->placeholder('Never Expires')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active Status'),
                SelectFilter::make('discount_type')
                    ->label('Type')
                    ->options([
                        'fixed' => 'Fixed Amount (₱)',
                        'percent' => 'Percentage (%)',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
