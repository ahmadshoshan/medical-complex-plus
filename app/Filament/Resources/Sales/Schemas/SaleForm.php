<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SaleForm
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
                TextInput::make('price')->label('السعر')
                    ->required()
                    ->numeric()
                    ->prefix('ج.م'),
                DatePicker::make('sale_date')->label( 'التاريخ')->default(fn() => now())
                    ->required(),
                TextInput::make('customer')->label('العميل')
                    ->default(null),
            ]);
    }
}
