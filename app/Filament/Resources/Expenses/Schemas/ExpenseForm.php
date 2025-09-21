<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')->label('المبلغ')
                    ->required()
                    ->numeric(),
                DatePicker::make('date')->label('التاريخ')
                    ->required(),
                TextInput::make('category')->label('الفئة')
                    ->required(),
                Textarea::make('description')->label('الوصف')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
