<?php

namespace App\Filament\Resources\Purchases\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([



                TextInput::make('item')->label('الصنف')->required(),
                TextInput::make('quantity')->numeric()->label('الكمية')->required(),
                TextInput::make('price')->numeric()->label('السعر')->required()->prefix('ج.م'),
                DatePicker::make('purchase_date')->label('تاريخ الشراء')->required()->default(fn() => now()),
                TextInput::make('supplier')->label('المورد')->default(null),
            ]);
    }
}
