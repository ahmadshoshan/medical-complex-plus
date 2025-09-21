<?php

namespace App\Filament\Resources\Doctors\Resources\AppointmentDoctors;

use App\Filament\Resources\Doctors\DoctorResource;
use App\Filament\Resources\Doctors\Resources\AppointmentDoctors\Pages\CreateAppointmentDoctors;
use App\Filament\Resources\Doctors\Resources\AppointmentDoctors\Pages\EditAppointmentDoctors;
use App\Filament\Resources\Doctors\Resources\AppointmentDoctors\Schemas\AppointmentDoctorsForm;
use App\Filament\Resources\Doctors\Resources\AppointmentDoctors\Tables\AppointmentDoctorsTable;
use App\Models\AppointmentDoctors;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AppointmentDoctorsResource extends Resource
{
    protected static ?string $model = AppointmentDoctors::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = DoctorResource::class;


    protected static ?string $recordTitleAttribute = 'deys';
     protected static ?string $pluralModelLabel = 'المواعيد';

    protected static ?string $modelLabel = 'موعد'; // اسم مفرد

    public static function form(Schema $schema): Schema
    {
        return AppointmentDoctorsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AppointmentDoctorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateAppointmentDoctors::route('/create'),
            'edit' => EditAppointmentDoctors::route('/{record}/edit'),
        ];
    }
}
