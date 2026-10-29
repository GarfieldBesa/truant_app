<?php

namespace App\Filament\Resources\Vouchers\Pages;

use App\Filament\Resources\Vouchers\VoucherResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVoucher extends CreateRecord
{
    protected static string $resource = VoucherResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = strtoupper(trim($data['code']));
        $data['created_by'] = auth()->id();

        return $data;
    }
}
