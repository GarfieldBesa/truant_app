<?php

namespace App\Filament\Resources\Vouchers\Schemas;

use App\Models\Voucher;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VoucherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Voucher Secret Code')
                    ->placeholder('e.g. VIP100, SUMMER20, SECRET50')
                    ->required()
                    ->unique(Voucher::class, 'code', ignoreRecord: true)
                    ->maxLength(50)
                    ->extraInputAttributes(['style' => 'text-transform: uppercase; font-family: monospace; font-weight: bold;'])
                    ->helperText('This code is kept secret by admin and given directly to selected users.'),
                TextInput::make('name')
                    ->label('Voucher Description / Internal Name')
                    ->placeholder('e.g. Special VIP ₱100 Discount')
                    ->required()
                    ->maxLength(255),
                Select::make('discount_type')
                    ->label('Discount Type')
                    ->options([
                        'fixed' => 'Fixed Peso Amount (₱)',
                        'percent' => 'Percentage Discount (%)',
                    ])
                    ->default('fixed')
                    ->required(),
                TextInput::make('discount_value')
                    ->label('Discount Value')
                    ->numeric()
                    ->required()
                    ->minValue(0.01)
                    ->placeholder('100.00')
                    ->helperText('Enter fixed amount in Pesos (e.g. 100 for ₱100 off) or percentage (e.g. 20 for 20% off).'),
                TextInput::make('min_spend')
                    ->label('Minimum Booking Spend (₱)')
                    ->numeric()
                    ->nullable()
                    ->placeholder('e.g. 350.00')
                    ->helperText('Minimum booking subtotal (court + rental gear) required before this voucher applies.'),
                TextInput::make('max_discount')
                    ->label('Max Discount Cap (₱)')
                    ->numeric()
                    ->nullable()
                    ->placeholder('e.g. 200.00')
                    ->helperText('Optional upper limit on discount amount when using percentage type.'),
                TextInput::make('usage_limit')
                    ->label('Global Total Usage Limit')
                    ->numeric()
                    ->nullable()
                    ->placeholder('Leave blank for unlimited')
                    ->helperText('Total number of times this voucher can be redeemed overall.'),
                TextInput::make('usage_limit_per_user')
                    ->label('Usage Limit Per Customer')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->minValue(1)
                    ->helperText('How many times a registered player can redeem this voucher.'),
                DateTimePicker::make('starts_at')
                    ->label('Activation Start Time')
                    ->nullable()
                    ->helperText('Leave empty to activate immediately.'),
                DateTimePicker::make('expires_at')
                    ->label('Expiration Date & Time')
                    ->nullable()
                    ->helperText('Leave empty for no expiration.'),
                Toggle::make('is_active')
                    ->label('Voucher Active')
                    ->default(true)
                    ->helperText('Toggle off to temporarily disable redemption.'),
            ]);
    }
}
