<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Schema;

class RoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               TextInput::make('room_number')
                    ->label('رقم الغرفة')
                    ->numeric()
                    ->required(),
              Select::make('doctor_id')
                    ->label('الطبيب')
                    ->relationship('doctor','name')
                    ->searchable()

                        ->preload(),

               TextInput::make('description')
                    ->label('الوصف'),
            ]);
    }
}
