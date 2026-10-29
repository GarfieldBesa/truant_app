<?php

namespace App\Filament\Resources\CourtBookings\Schemas;

use App\Models\CourtBooking;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CourtBookingForm
{
    public static function configure(Schema $schema): Schema
    {
        $hourOptions = [];
        for ($h = 0; $h < 24; $h++) {
            $hourOptions[$h] = CourtBooking::formatHourRange($h, $h + 1);
        }

        return $schema
            ->components([
                TextInput::make('reference_code')
                    ->label('Reference Code')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Auto-generated upon save'),
                Select::make('court_id')
                    ->label('Court')
                    ->relationship('court', 'name')
                    ->required(),
                DatePicker::make('booking_date')
                    ->label('Booking Date')
                    ->required(),
                Select::make('start_hour')
                    ->label('Time Slot')
                    ->options($hourOptions)
                    ->required(),
                TextInput::make('slots_count')
                    ->label('Slots Count')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->required(),
                TextInput::make('court_fee')
                    ->label('Court Fee (PHP)')
                    ->numeric()
                    ->prefix('₱')
                    ->default(0.00),
                TextInput::make('rentals_fee')
                    ->label('Rentals Fee (PHP)')
                    ->numeric()
                    ->prefix('₱')
                    ->default(0.00),
                TextInput::make('total_amount')
                    ->label('Total Amount (PHP)')
                    ->numeric()
                    ->prefix('₱')
                    ->default(0.00),
                Select::make('status')
                    ->label('Reservation Status')
                    ->options([
                        'pending_verification' => 'Pending Email Verification',
                        'verified' => 'Verified (Awaiting Payment Confirmation)',
                        'confirmed' => 'Confirmed',
                        'declined' => 'Declined',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                TextInput::make('customer_name')
                    ->label('Customer Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('customer_email')
                    ->label('Customer Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('customer_contact')
                    ->label('Contact Number')
                    ->required()
                    ->maxLength(50),
                Select::make('payment_mode')
                    ->label('Mode of Payment')
                    ->options([
                        'cash_on_site' => 'Cash on Site / Over the Counter',
                        'gcash' => 'GCash / E-Wallet',
                        'bank_transfer' => 'Bank Transfer',
                    ])
                    ->nullable(),
                TextInput::make('payment_notes')
                    ->label('Payment Reference / Notes')
                    ->nullable()
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->label('Customer Notes / Special Requests')
                    ->rows(2)
                    ->columnSpanFull(),
                Textarea::make('decline_reason')
                    ->label('Decline Reason (If declined)')
                    ->rows(2)
                    ->visible(fn ($get) => $get('status') === 'declined')
                    ->columnSpanFull(),
                Textarea::make('admin_notes')
                    ->label('Internal Admin Notes')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }
}
