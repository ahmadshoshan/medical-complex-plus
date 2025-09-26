<?php

namespace App\Filament\Resources\Custodies;

use App\Filament\Resources\Custodies\Pages\CreateCustody;
use App\Filament\Resources\Custodies\Pages\EditCustody;
use App\Filament\Resources\Custodies\Pages\ListCustodies;
use App\Filament\Resources\Custodies\Pages\ViewCustody;
use App\Filament\Resources\Custodies\Schemas\CustodyForm;
use App\Filament\Resources\Custodies\Schemas\CustodyInfolist;
use App\Filament\Resources\Custodies\Tables\CustodiesTable;
use App\Models\Custody;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CustodyResource extends Resource
{
    protected static ?string $model = Custody::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'item';
    protected static string|\UnitEnum|null $navigationGroup = 'ادارةالحسابات ';

    protected static ?string $label = 'عهدة';
    protected static ?string $pluralLabel = 'العهدة';
    public static function form(Schema $schema): Schema
    {
        return CustodyForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CustodyInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustodiesTable::configure($table);
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
            'index' => ListCustodies::route('/'),
            'create' => CreateCustody::route('/create'),
            'view' => ViewCustody::route('/{record}'),
            'edit' => EditCustody::route('/{record}/edit'),
        ];
    }
}
