<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->label('رقم الفاتورة')
                    ->required()
                    ->unique(ignoreRecord: true),

                DatePicker::make('invoice_date')
                    ->label('تاريخ الفاتورة')
                    ->required(),

                Select::make('type')
                    ->label('نوع الفاتورة')
                    ->options([
                        'purchase' => 'شراء',
                        'sale' => 'بيع',
                    ])
                    ->required(),

                TextInput::make('total')
                    ->label('الإجمالي')
                    ->numeric()
                    ->required(),

                TextInput::make('customer')
                    ->label('العميل')
                    ->visible(fn($get) => $get('type') === 'sale'),

                TextInput::make('supplier')
                    ->label('المورد')
                    ->visible(fn($get) => $get('type') === 'purchase'),

                Textarea::make('notes')
                    ->label('ملاحظات'),
            ]);
    }
}
