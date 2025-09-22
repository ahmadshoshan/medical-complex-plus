<?php

namespace App\Filament\Resources\WaitingLists\Pages;

use App\Filament\Resources\WaitingLists\WaitingListResource;
use App\Models\WaitingList;
use Filament\Resources\Pages\CreateRecord;

class CreateWaitingList extends CreateRecord
{
    protected static string $resource = WaitingListResource::class;
  protected function getRedirectUrl(): string
    {
        // بعد إنشاء الحالة، يروح لصفحة الطباعة
        return route('waiting-list.print', $this->record);
    }
    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }



    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $amount = $data['amount'] ?? null;

        if ($amount && $amount > 0) {
            // احفظه مؤقتًا
            WaitingList::$temporaryAmount = $amount;
        }

        // احذفه من قاعدة البيانات
        unset($data['amount']);

        return $data;
    }
}
