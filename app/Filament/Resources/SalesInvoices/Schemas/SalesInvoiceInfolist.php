<?php

namespace App\Filament\Resources\SalesInvoices\Schemas;


use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SalesInvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الفاتورة')
                    ->schema([
                        TextEntry::make('invoice_number')
                            ->label('رقم الفاتورة'),
                        TextEntry::make('patient.name')
                            ->label('المريض')
                            ->default('عميل نقدي'),
                        TextEntry::make('invoice_date')
                            ->label('التاريخ')
                            ->date('Y-m-d'),
                        TextEntry::make('status')
                            ->label('الحالة')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'pending' => 'warning',
                                'partial' => 'info',
                                'paid' => 'success',
                                'canceled' => 'danger',
                                default => 'gray',
                            }),
                    ])->columns(2),

                Section::make('الإجماليات')
                    ->schema([
                        TextEntry::make('subtotal')
                            ->label('المجموع الفرعي')
                            ->numeric()
                            ->suffix(' ج.م'),
                        TextEntry::make('discount')
                            ->label('الخصم')
                            ->numeric()
                            ->suffix(' ج.م'),
                        TextEntry::make('tax')
                            ->label('الضريبة')
                            ->numeric()
                            ->suffix(' ج.م'),
                        TextEntry::make('total')
                            ->label('الإجمالي')
                            ->numeric()
                            ->suffix(' ج.م')
                            ->weight('bold'),
                        TextEntry::make('paid_amount')
                            ->label('المدفوع')
                            ->numeric()
                            ->suffix(' ج.م'),
                        TextEntry::make('remaining_amount')
                            ->label('المتبقي')
                            ->numeric()
                            ->suffix(' ج.م')
                            ->color(fn($state) => $state > 0 ? 'danger' : 'success'),
                    ])->columns(3),

                Section::make('ملاحظات')
                    ->schema([
                        TextEntry::make('notes')
                            ->label('ملاحظات')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}