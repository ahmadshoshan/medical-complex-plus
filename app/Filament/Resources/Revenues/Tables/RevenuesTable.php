<?php

namespace App\Filament\Resources\Revenues\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RevenuesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')
                    ->numeric()
                    ->label('المبلغ')
                    ->suffix(' ج.م')
                    ->sortable(),
                TextColumn::make('date')->label('التاريخ')
                    ->date()
                    ->sortable(),
                TextColumn::make('type')->label('النوع')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('التفاصيل')
                    ->default(
                        function ($record) {
                            if (empty($record->description)) {
                                return " الحالة /   {$record->patient->name}  -- الطبيب / {$record->doctor->name}  ";
                            }
                            return $record->description;
                        }

                    ),

                // TextColumn::make('patient_id')  ->label('الحاله')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('doctor_id')  ->label('الطبيب')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('waiting_lists_id')
                //     ->numeric()
                //     ->sortable(),
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
