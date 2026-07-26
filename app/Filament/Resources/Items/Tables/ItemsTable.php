<?php

namespace App\Filament\Resources\Items\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم الصنف')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('barcode')
                    ->label('الباركود')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('الفئة')
                    ->searchable(),
                TextColumn::make('stock_quantity')
                    ->label('الكمية')
                    ->numeric()
                    ->sortable()
                    ->color(fn($record) => $record->stock_quantity <= $record->min_stock ? 'danger' : 'success'),
                TextColumn::make('min_stock')
                    ->label('الحد الأدنى')
                    ->numeric(),
                TextColumn::make('cost_price')
                    ->label('سعر التكلفة')
                    ->numeric()
                    ->suffix(' ج.م')
                    ->sortable(),
                TextColumn::make('selling_price')
                    ->label('سعر البيع')
                    ->numeric()
                    ->suffix(' ج.م')
                    ->sortable(),
                TextColumn::make('created_at')
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