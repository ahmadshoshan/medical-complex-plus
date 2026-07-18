<?php

namespace App\Filament\Resources\Invoices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('invoice_number')->label('رقم الفاتورة')->sortable()->searchable(),
            TextColumn::make('invoice_date')->label('تاريخ'),
            TextColumn::make('type')->label('النوع')->formatStateUsing(fn ($state) => $state === 'sale' ? 'بيع' : 'شراء'),
            TextColumn::make('total')->label('الإجمالي')->money('EGP'),
            TextColumn::make('customer')->label('العميل'),
            TextColumn::make('supplier')->label('المورد'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
