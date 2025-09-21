<?php

namespace App\Filament\Resources\WaitingLists\Pages;

use App\Filament\Resources\WaitingLists\WaitingListResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWaitingList extends EditRecord
{
    protected static string $resource = WaitingListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
        protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
