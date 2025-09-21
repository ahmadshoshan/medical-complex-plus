<?php

namespace App\Filament\Resources\AppointmentDoctors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AppointmentDoctorsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('doctor_id')->label('الطبيب')
                    ->relationship('doctor', 'name')
                    ->required(),
               Select::make('days')
                    ->label('اليوم')
                    ->options([
                      "السبت"   =>   "السبت",
                      "الأحد"   =>   "الأحد",
                      "الإثنين" =>   "الإثنين",
                      "الثلاثاء"=>   "الثلاثاء",
                      "الأربعاء"=>   "الأربعاء",
                      "الخميس"  =>   "الخميس",
                      "الجمعة"  =>   "الجمعة",
                    ])
                    ->multiple() // يسمح باختيار أكثر من يوم
                    ->searchable()
                    ->required()
                    ->native(false), // لتحسين الشكل في الواجهة
                TimePicker::make('start_time')->label('من'),
                TimePicker::make('end_time')->label('الي'),

                Textarea::make('notes')->label('ملاحظة')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
