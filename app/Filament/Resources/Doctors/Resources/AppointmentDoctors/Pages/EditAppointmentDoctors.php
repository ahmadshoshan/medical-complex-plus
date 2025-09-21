<?php

namespace App\Filament\Resources\Doctors\Resources\AppointmentDoctors\Pages;

use App\Filament\Resources\Doctors\Resources\AppointmentDoctors\AppointmentDoctorsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAppointmentDoctors extends EditRecord
{
    protected static string $resource = AppointmentDoctorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
