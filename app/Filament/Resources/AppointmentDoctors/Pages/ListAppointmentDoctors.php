<?php

namespace App\Filament\Resources\AppointmentDoctors\Pages;

use App\Filament\Resources\AppointmentDoctors\AppointmentDoctorsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAppointmentDoctors extends ListRecords
{
    protected static string $resource = AppointmentDoctorsResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make(),
    //     ];
    // }
      protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
