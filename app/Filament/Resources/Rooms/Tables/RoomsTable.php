<?php

namespace App\Filament\Resources\Rooms\Tables;

use App\Models\Room;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoomsTable
{
      public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Room::getEloquentQuery()
            ->select(['id', 'room_number',  'description'])
            ->with(['doctor:id,name']);
    }
    public static function configure(Table $table): Table
    {
        return $table
          ->columns([
                TextColumn::make('room_number')
                    ->label('رقم الغرفة'),
                TextColumn::make('doctor.name')
                    ->label('الطبيب'),
                TextColumn::make('description')
                    ->label('الوصف'),

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
