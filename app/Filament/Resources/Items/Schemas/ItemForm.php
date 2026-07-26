<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الصنف')
                    ->schema([
                        TextInput::make('name')
                            ->label('اسم الصنف')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('barcode')
                            ->label('الباركود')
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),
                        TextInput::make('category')
                            ->label('الفئة')
                            ->maxLength(100),
                        TextInput::make('unit')
                            ->label('الوحدة')
                            ->default('قطعة')
                            ->maxLength(50),
                        Textarea::make('description')
                            ->label('الوصف')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('أسعار الصنف')
                    ->schema([
                        TextInput::make('cost_price')
                            ->label('سعر التكلفة')
                            ->numeric()
                            ->default(0)
                            ->prefix('ج.م')
                            ->minValue(0),
                        TextInput::make('selling_price')
                            ->label('سعر البيع')
                            ->numeric()
                            ->default(0)
                            ->prefix('ج.م')
                            ->minValue(0),
                    ])->columns(2),

                Section::make('إعدادات المخزون')
                    ->schema([
                        TextInput::make('stock_quantity')
                            ->label('الكمية الحالية')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        TextInput::make('min_stock')
                            ->label('الحد الأدنى للمخزون')
                            ->numeric()
                            ->default(10)
                            ->minValue(0)
                            ->helperText('سيتم التنبيه عند وصول المخزون لهذا الحد'),
                    ])->columns(2),
            ]);
    }
}