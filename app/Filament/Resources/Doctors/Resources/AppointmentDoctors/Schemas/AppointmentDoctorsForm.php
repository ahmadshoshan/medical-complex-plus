<?php

namespace App\Filament\Resources\Doctors\Resources\AppointmentDoctors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AppointmentDoctorsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('doctor_id')
                    ->required()
                    ->numeric(),
                TimePicker::make('start_time'),
                TimePicker::make('end_time'),
                TextInput::make('days')
                    ->required(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
