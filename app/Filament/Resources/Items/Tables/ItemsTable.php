<?php

namespace App\Filament\Resources\Items\Tables;

use App\Filament\Resources\Items\Pages\CreateItem;
use App\Filament\Resources\Items\Pages\EditItem;
use App\Filament\Resources\Items\Pages\ListItems;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
  ->columns([
                TextColumn::make('name')->label('اسم الصنف')->searchable(),
                TextColumn::make('category.name')->label('التصنيف')->sortable(),
                TextColumn::make('unit')->label('الوحدة'),
                TextColumn::make('barcode')->label('الباركود'),
                TextColumn::make('purchase_price')->label('سعر الشراء')->money('EGP'),
                TextColumn::make('sale_price')->label('سعر البيع')->money('EGP'),
                TextColumn::make('quantity')->label('المخزون')->sortable(),
                TextColumn::make('expiry_date')->label('تاريخ الصلاحية')->date(),
                TextColumn::make('created_at')->label('تاريخ الإضافة')->dateTime('d-m-Y'),
            ])
            ->filters([
                // فلتر المخزون قليل
                Filter::make('low_stock')
                    ->label('أصناف قربت تخلص')
                    ->query(fn ($query) => $query->whereColumn('quantity', '<=', 'min_quantity')),
            ])
            ->recordActions([
                EditAction::make()->label('تعديل'),
                DeleteAction::make()->label('حذف'),
            ])
            ->toolbarActions([
                DeleteBulkAction::make()->label('حذف الكل'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' =>ListItems::route('/'),
            'create' =>CreateItem::route('/create'),
            'edit' =>EditItem::route('/{record}/edit'),
        ];
    }
}
