<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SaleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('item'),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('sale_date')
                    ->date(),
                TextEntry::make('customer'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
