<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('اسم الصنف')
                    ->required(),

            //    Select::make('category_id')
            //         ->label('التصنيف')
            //         ->relationship('category', 'name')
            //         ->searchable()
            //         ->preload()
            //         ->required(),

               TextInput::make('unit')
                    ->label('الوحدة (علبة - شريط - أمبولة)')
                    ->required(),

               TextInput::make('barcode')
                    ->label('الباركود')
                    ->unique(ignoreRecord: true),

               TextInput::make('purchase_price')
                    ->label('سعر الشراء')
                    ->numeric()
                    ->required(),

               TextInput::make('sale_price')
                    ->label('سعر البيع')
                    ->numeric()
                    ->required(),

               TextInput::make('quantity')
                    ->label('الكمية المتاحة')
                    ->numeric()
                    ->default(0),

               TextInput::make('min_quantity')
                    ->label('حد إعادة الطلب')
                    ->numeric()
                    ->default(5),

               DatePicker::make('expiry_date')
                    ->label('تاريخ الصلاحية')
                    ->nullable(),
            ]);
    }
}
