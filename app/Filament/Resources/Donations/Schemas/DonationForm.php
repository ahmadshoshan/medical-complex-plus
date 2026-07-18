<?php

namespace App\Filament\Resources\Donations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DonationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')->label(' المبلغ')
                    ->required()
                    ->default(0)
                    ->numeric(),
                DatePicker::make('date')->label(' التاريخ')
                ->default(fn() => now())
                    ->required(),
                TextInput::make('donor_name')->label(' الاسم')
                    ->default(null),

                Textarea::make('notes')->label(' تفاصيل')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
