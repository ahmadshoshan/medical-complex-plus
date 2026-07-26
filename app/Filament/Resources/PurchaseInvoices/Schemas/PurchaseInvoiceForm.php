<?php

namespace App\Filament\Resources\PurchaseInvoices\Schemas;

use App\Models\Item;
use App\Models\Supplier;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PurchaseInvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الفاتورة')
                    ->schema([
                        TextInput::make('invoice_number')
                            ->label('رقم الفاتورة')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(fn() => 'PUR-' . date('Ymd') . '-' . rand(1000, 9999)),
                        Select::make('supplier_id')
                            ->label('المورد')
                            ->options(Supplier::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        DatePicker::make('invoice_date')
                            ->label('تاريخ الفاتورة')
                            ->required()
                            ->default(now()),
                    ])->columns(3),

                Section::make('بنود الفاتورة')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('item_id')
                                    ->label('الصنف')
                                    ->options(Item::pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $item = Item::find($state);
                                            if ($item) {
                                                $set('item_name', $item->name);
                                                $set('cost_price', $item->cost_price ?? 0);
                                                $set('selling_price', $item->selling_price ?? 0);
                                            }
                                        }
                                    }),
                                Hidden::make('item_name'),
                                TextInput::make('quantity')
                                    ->label('الكمية')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->default(1)
                                    ->live()
                                    ->afterStateUpdated(fn($state, callable $set, callable $get) =>
                                        $set('total', ($state ?? 0) * ($get('cost_price') ?? 0))
                                    ),
                                TextInput::make('cost_price')
                                    ->label('سعر التكلفة')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->prefix('ج.م')
                                    ->live()
                                    ->afterStateUpdated(fn($state, callable $set, callable $get) =>
                                        $set('total', ($get('quantity') ?? 0) * ($state ?? 0))
                                    ),
                                TextInput::make('selling_price')
                                    ->label('سعر البيع')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->prefix('ج.م'),
                                TextInput::make('total')
                                    ->label('الإجمالي')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('ج.م'),
                            ])->columns(6)
                            ->defaultItems(1)
                            ->addActionLabel('إضافة صنف')
                            ->reorderableWithButtons()
                            ->collapsible(),
                    ]),

                Section::make('الإجماليات')
                    ->schema([
                        TextInput::make('subtotal')
                            ->label('المجموع الفرعي')
                            ->numeric()
                            ->readOnly()
                            ->prefix('ج.م'),
                        TextInput::make('discount')
                            ->label('الخصم')
                            ->numeric()
                            ->default(0)
                            ->prefix('ج.م'),
                        TextInput::make('tax')
                            ->label('الضريبة')
                            ->numeric()
                            ->default(0)
                            ->prefix('ج.م'),
                        TextInput::make('total')
                            ->label('الإجمالي النهائي')
                            ->numeric()
                            ->readOnly()
                            ->prefix('ج.م'),
                        TextInput::make('paid_amount')
                            ->label('المبلغ المدفوع')
                            ->numeric()
                            ->default(0)
                            ->prefix('ج.م'),
                        TextInput::make('remaining_amount')
                            ->label('المتبقي')
                            ->numeric()
                            ->readOnly()
                            ->prefix('ج.م'),
                        Select::make('status')
                            ->label('الحالة')
                            ->options([
                                'pending' => 'معلقة',
                                'partial' => 'مدفوعة جزئياً',
                                'paid' => 'مدفوعة بالكامل',
                                'canceled' => 'ملغاة',
                            ])
                            ->required(),
                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }
}