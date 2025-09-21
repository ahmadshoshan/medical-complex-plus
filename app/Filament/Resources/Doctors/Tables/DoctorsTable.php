<?php

namespace App\Filament\Resources\Doctors\Tables;

use App\Models\Doctor;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DoctorsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->defaultPaginationPageOption(10) // ✅ عرض 10 بس في الصفحة
            ->columns([
                TextColumn::make('name') ->label('الاسم')
                    ->searchable(),
                TextColumn::make('user.name')->label('اسم المستخدم ')
                    ->searchable(),
                TextColumn::make('specialty')->label('التخصص')
                    ->searchable(),
                TextColumn::make('phone')->label('الهاتف')
,
                IconColumn::make('is_active')->label('نشط')
                    ->boolean(),
                    TextColumn::make('bio')->label('نبذة تعريفية')
                    ->toggleable(isToggledHiddenByDefault: true),
                //     TextColumn::make('created_at')
                //         ->dateTime()

                //         ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('updated_at')
                //     ->dateTime()

                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
