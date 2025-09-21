<?php

namespace App\Filament\Resources\WaitingLists\Pages;

use App\Filament\Resources\WaitingLists\WaitingListResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\On;

class ListWaitingLists extends ListRecords
{
    protected static string $resource = WaitingListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

     protected $listeners = [
        'echo:waiting-list,WaitingListUpdated' => 'handleWaitingListUpdated',
    ];

    #[On('echo:waiting-list,WaitingListUpdated')]
    public function handleWaitingListUpdated($payload = null): void
    {
        // simplest reliable way: force Livewire to re-render this component (and the table inside it)
        $this->dispatch('$refresh');
    }
}
