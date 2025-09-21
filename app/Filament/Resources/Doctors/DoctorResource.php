<?php

namespace App\Filament\Resources\Doctors;

use App\Filament\Resources\Doctors\Pages\CreateDoctor;
use App\Filament\Resources\Doctors\Pages\EditDoctor;
use App\Filament\Resources\Doctors\Pages\ListDoctors;
use App\Filament\Resources\Doctors\RelationManagers\AppointmentDoctorsRelationManager;
use App\Filament\Resources\Doctors\Schemas\DoctorForm;
use App\Filament\Resources\Doctors\Tables\DoctorsTable;
use App\Models\AppointmentDoctors;
use App\Models\Doctor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 2;
    protected static string|\UnitEnum|null $navigationGroup = 'ادارة الاطباء';
    protected static ?string $pluralModelLabel = 'الأطباء'; // اسم العرض في القائمة

    protected static ?string $modelLabel = 'طبيب'; // اسم مفرد
    protected static ?string $relatedResource = AppointmentDoctors::class;
    public static function getNavigationBadge(): ?string
    {
        // return static::getModel()::where('status', 'waiting')->count();
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return DoctorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DoctorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AppointmentDoctorsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDoctors::route('/'),
            'create' => CreateDoctor::route('/create'),
            'edit' => EditDoctor::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->select(['id', 'name',  'specialty',  'phone',  'is_active',  'bio'])
            ->with(['user:id,name'])
            ->limit(5); // عرض 5 فقط;
    }
}
