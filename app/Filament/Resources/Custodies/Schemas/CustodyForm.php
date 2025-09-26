<?php

namespace App\Filament\Resources\Custodies\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustodyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('item')->label('الصنف')
                    ->required(),
                TextInput::make('quantity')->label('الكمية')
                    ->required()
                    ->numeric(),
                TextInput::make('employee')->label('الموظف')
                    ->required(),
                DatePicker::make('handover_date')->label('تاريخ التسيم')
                    ->required(),
            ]);
    }
}
