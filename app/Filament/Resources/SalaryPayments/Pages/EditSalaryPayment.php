<?php

namespace App\Filament\Resources\SalaryPayments\Pages;

use App\Filament\Resources\SalaryPayments\SalaryPaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSalaryPayment extends EditRecord
{
    protected static string $resource = SalaryPaymentResource::class;
       protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
