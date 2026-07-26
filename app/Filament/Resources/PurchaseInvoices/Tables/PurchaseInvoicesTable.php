<?php

namespace App\Filament\Resources\PurchaseInvoices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PurchaseInvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('رقم الفاتورة')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('supplier.name')
                    ->label('المورد')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('invoice_date')
                    ->label('التاريخ')
                    ->date('Y-m-d')
                    ->sortable(),
                TextColumn::make('total')
                    ->label('الإجمالي')
                    ->numeric()
                    ->suffix(' ج.م')
                    ->sortable(),
                TextColumn::make('paid_amount')
                    ->label('المدفوع')
                    ->numeric()
                    ->suffix(' ج.م'),
                TextColumn::make('remaining_amount')
                    ->label('المتبقي')
                    ->numeric()
                    ->suffix(' ج.م')
                    ->color(fn($record) => $record->remaining_amount > 0 ? 'danger' : 'success'),
                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'معلقة',
                        'partial' => 'جزئية',
                        'paid' => 'مدفوعة',
                        'canceled' => 'ملغاة',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'partial' => 'info',
                        'paid' => 'success',
                        'canceled' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'معلقة',
                        'partial' => 'جزئية',
                        'paid' => 'مدفوعة',
                        'canceled' => 'ملغاة',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}