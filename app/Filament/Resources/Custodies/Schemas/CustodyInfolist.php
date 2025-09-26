<?php

namespace App\Filament\Resources\Custodies\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CustodyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('item'),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('employee'),
                TextEntry::make('handover_date')
                    ->date(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
