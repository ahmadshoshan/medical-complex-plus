<?php

namespace App\Filament\Resources\AppointmentDoctors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AppointmentDoctorsTable
{


    public static function configure(Table $table): Table
    {

        return $table
            ->defaultPaginationPageOption(10) // أسرع مع عدد قليل
            ->columns([
                TextColumn::make('doctor.name')->label('الطبيب')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('days')
                    ->label('الأيام')

                    ->badge()
                    ->colors(['primary']),

                TextColumn::make('start_time')->label('من')
                    ->time(),
                TextColumn::make('end_time')->label('الي')
                    ->time(),
                // TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
