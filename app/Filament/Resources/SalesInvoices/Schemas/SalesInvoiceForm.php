<?php

namespace App\Filament\Resources\SalesInvoices\Schemas;

use App\Models\Item;
use App\Models\Patient;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;


use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SalesInvoiceForm
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
                            ->default(fn() => 'INV-' . date('Ymd') . '-' . rand(1000, 9999)),
                        Select::make('patient_id')
                            ->label('المريض')
                            ->options(Patient::pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),
                        DatePicker::make('invoice_date')
                            ->label('تاريخ الفاتورة')
                            ->required()
                            ->default(now()),
                    ])->columns(3)->columnSpanFull(),

                Section::make('بنود الفاتورة')
                    ->schema([
                        Repeater::make('items')
                            ->label('الأصناف')
                            ->relationship()
                            ->schema([
                                Select::make('item_id')
                                    ->label('الصنف')
                                    ->options(Item::where('stock_quantity', '>', 0)->pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        if ($state) {
                                            $item = Item::find($state);
                                            if ($item) {
                                                $set('item_name', $item->name);
                                                $set('unit_price', $item->selling_price ?? 0);
                                                
                                           

                                                // 2. جلب القيم الحالية
                                                $quantity = $get('quantity') ?? 1;
                                                $unitPrice = $item->selling_price ?? 0; // استخدم السعر الجديد مباشرة
                                                $discount = $get('discount') ?? 0;

                                                // 3. حساب الإجمالي (المعادلة الصحيحة)
                                                $total = ($quantity * $unitPrice) - $discount;
                                                $set('total', max(0, $total));

                                                // تحديث إجماليات الفاتورة فوراً
                                                self::updateInvoiceTotals($get, $set);
                                            }
                                        } else {
                                            $set('item_name', null);
                                            $set('unit_price', 0);
                                            $set('total', 0);
                                            self::updateInvoiceTotals($get, $set);
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
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $quantity = (float) ($state ?? 1);
                                        $unitPrice = (float) ($get('unit_price') ?? 0);
                                        $discount = (float) ($get('discount') ?? 0);
                                        
                                        $total = max(0, ($quantity * $unitPrice) - $discount);
                                        $set('total', $total);
                                        
                                        self::updateInvoiceTotals($get, $set);
                                    }),
                                
                                TextInput::make('unit_price')
                                    ->label('سعر الوحدة')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->prefix('ج.م')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $quantity = (float) ($get('quantity') ?? 1);
                                        $unitPrice = (float) ($state ?? 0);
                                        $discount = (float) ($get('discount') ?? 0);
                                        
                                        $total = max(0, ($quantity * $unitPrice) - $discount);
                                        $set('total', $total);
                                        
                                        self::updateInvoiceTotals($get, $set);
                                    }),
                                
                                TextInput::make('discount')
                                    ->label('الخصم')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->prefix('ج.م')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $quantity = (float) ($get('quantity') ?? 1);
                                        $unitPrice = (float) ($get('unit_price') ?? 0);
                                        $discount = (float) ($state ?? 0);
                                        
                                        $total = max(0, ($quantity * $unitPrice) - $discount);
                                        $set('total', $total);
                                        
                                        self::updateInvoiceTotals($get, $set);
                                    }),
                                
                                TextInput::make('total')
                                    ->label('إجمالي الصنف')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('ج.م'),
                            ])
                            ->columns(5)
                            ->defaultItems(1)
                            ->addActionLabel('إضافة صنف')
                            ->reorderableWithButtons()
                            ->collapsible(),
                    ])->columnSpanFull(),

                Section::make('الإجماليات')
                    ->schema([
                        TextInput::make('subtotal')
                            ->label('المجموع الفرعي')
                            ->numeric()
                            ->readOnly()
                            ->prefix('ج.م')
                            ->default(0),
                        TextInput::make('discount')
                            ->label('خصم إضافي')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->prefix('ج.م')
                            ->live()
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::updateInvoiceTotals($get, $set)),
                        TextInput::make('tax')
                            ->label('الضريبة')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->prefix('ج.م')
                            ->live()
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::updateInvoiceTotals($get, $set)),
                        TextInput::make('total5')
                            ->label('الإجمالي النهائي')
                            ->numeric()
                            ->readOnly()
                            ->prefix('ج.م')
                            ->default(0),
                        TextInput::make('paid_amount')
                            ->label('المبلغ المدفوع')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->prefix('ج.م')
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateInvoiceTotals($get, $set);
                            }),
                        TextInput::make('remaining_amount')
                            ->label('المتبقي')
                            ->numeric()
                            ->readOnly()
                            ->prefix('ج.م')
                            ->default(0)
                         ,
                        Select::make('status')
                            ->label('الحالة')
                            ->options([
                                'pending' => 'معلقة',
                                'partial' => 'مدفوعة جزئياً',
                                'paid' => 'مدفوعة بالكامل',
                                'canceled' => 'ملغاة',
                            ])
                            ->required()
                            ->default('pending'),
                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->columnSpanFull(),
                    ])->columns(3)->columnSpanFull(),
            ]);
    }

    /**
     * ✅ دالة موحدة ومضمونة لتحديث إجماليات الفاتورة
     */
    private static function updateInvoiceTotals(Get $get, Set $set): void
    {
           // 1. حساب المجموع الفرعي من بنود الفاتورة
        $items = $get('items') ?? [];
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += (float) ($item['total'] ?? 0);
        }
        $set('subtotal', $subtotal);

        // 2. حساب الإجمالي النهائي
        $discount = (float) ($get('discount') ?? 0);
        $tax = (float) ($get('tax') ?? 0);
        $total = $subtotal - $discount + $tax;
        $set('total5', max(0, $total));

        // 3. حساب المتبقي
        $paid = (float) ($get('paid_amount') ?? 0);
        $remaining = $total - $paid;
        $set('remaining_amount', max(0, $remaining));
    }
}