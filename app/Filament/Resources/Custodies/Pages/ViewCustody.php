<?php

namespace App\Filament\Resources\Custodies\Pages;

use App\Filament\Resources\Custodies\CustodyResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCustody extends ViewRecord
{
    protected static string $resource = CustodyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
