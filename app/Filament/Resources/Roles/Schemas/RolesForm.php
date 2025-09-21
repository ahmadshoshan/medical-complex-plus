<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;


class RolesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')->unique()
                    ->label('name')
                    ->required(),
                Select::make('permissions')
                    ->multiple()
                    ->relationship('permissions', 'name')
                    ->preload()
            ]);
    }
}
