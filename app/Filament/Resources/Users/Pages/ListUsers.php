<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    // #[On('echo:test,test')]
    // public function dump()
    // {
    //     Notification::make()
    //         ->title('تم الاستلام بنجاح!')
    //         ->success()
    //         ->send();

    //     Log::info('تم استلام الحدث!');
    // }
}
