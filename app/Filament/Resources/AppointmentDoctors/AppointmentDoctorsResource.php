<?php

namespace App\Filament\Resources\AppointmentDoctors;

use App\Filament\Resources\AppointmentDoctors\Pages\CreateAppointmentDoctors;
use App\Filament\Resources\AppointmentDoctors\Pages\EditAppointmentDoctors;
use App\Filament\Resources\AppointmentDoctors\Pages\ListAppointmentDoctors;
use App\Filament\Resources\AppointmentDoctors\Pages\ViewAppointmentDoctors;
use App\Filament\Resources\AppointmentDoctors\Schemas\AppointmentDoctorsForm;
use App\Filament\Resources\AppointmentDoctors\Schemas\AppointmentDoctorsInfolist;
use App\Filament\Resources\AppointmentDoctors\Tables\AppointmentDoctorsTable;
use App\Models\AppointmentDoctors;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AppointmentDoctorsResource extends Resource
{

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->select(['id', 'doctor_id', 'days', 'start_time', 'end_time'])
            ->with(['doctor:id,name']);
    }
    protected static ?string $model = AppointmentDoctors::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'doctor_id';
    protected static ?int $navigationSort = 3;
    protected static string|\UnitEnum|null $navigationGroup = 'ادارة الاطباء';
    protected static ?string $pluralModelLabel = 'مواعيدالأطباء'; // اسم العرض في القائمة

    protected static ?string $modelLabel = ' موعد طبيب'; // اسم مفرد
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
            'index' => ListAppointmentDoctors::route('/'),
            // 'create' => CreateAppointmentDoctors::route('/create'),
            // 'edit' => EditAppointmentDoctors::route('/{record}/edit'),
        ];
    }
}
