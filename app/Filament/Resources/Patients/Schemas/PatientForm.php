<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                ->label('الاسم')
                    ->required(),
                TextInput::make('phone')
                  ->label('الهاتف')
                    // ->required()
                    ->tel(),
                DatePicker::make('date_of_birth')
                 ->label('تاريخ الميلاد')
                    // ->required()
                    ,
                // Select::make('gender')
                //  ->label('النوع')
                //     ->options(['male' => 'ذكر', 'female' => 'أنثى'])
                //     // ->required()
                //     ,
                Textarea::make('address')
                 ->label('العنوان')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('medical_history')
                 ->label('السجل الطلب')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
