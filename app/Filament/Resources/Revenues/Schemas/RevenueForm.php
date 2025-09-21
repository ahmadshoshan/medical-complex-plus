<?php

namespace App\Filament\Resources\Revenues\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RevenueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount') ->label('المبلغ')
                    ->required()
                    ->numeric(),
                DatePicker::make('date')->label('التاريخ')->default(now()->toDateString())
                    ->required(),
                TextInput::make('type')->label('النوع')
                    ->required(),
                Textarea::make('description')->label('التفاصيل')
                    ->default(null)
                    ->columnSpanFull(),
                // TextInput::make('patient_id')
                //     ->numeric()
                //     ->default(null),
                // TextInput::make('doctor_id')
                //     ->numeric()
                //     ->default(null),
                // TextInput::make('waiting_lists_id')
                    // ->numeric()
                    // ->default(null),
            ]);
    }
}
