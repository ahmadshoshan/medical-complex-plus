<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('invoice_number'),
                TextEntry::make('invoice_date')
                    ->date(),
                TextEntry::make('type'),
                TextEntry::make('total')
                    ->numeric(),
                TextEntry::make('customer'),
                TextEntry::make('supplier'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
