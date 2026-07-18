<?php

namespace App\Filament\Resources\Users\Pages;

use App\Events\tast;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;


class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {

        // tast::dispatch('يببب');
        // // event(new tast());

        return [
            DeleteAction::make(),
        ];
    }
        protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
