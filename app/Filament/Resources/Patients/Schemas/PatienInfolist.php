<?php

namespace App\Filament\Resources\Patients\Schemas;


use Filament\Infolists\Components\TextEntry;

use Filament\Schemas\Schema;

class PatienInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                ->label('الاسم')
                    ,
                      TextEntry::make('national_id') // ✅ الرقم القومي
                    ->label('الرقم القومي')
                    ->numeric()
                   
                   
                    ,
                TextEntry::make('phone')
                  ->label('الهاتف')
                    // 
                   ,
             
                TextEntry::make('medical_history')
                 ->label('السجل الطلب')
                    
                    ->columnSpanFull(),
            ]);
    }
}
