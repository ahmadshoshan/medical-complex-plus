<?php

namespace App\Filament\Resources\Donations;

use App\Filament\Resources\Donations\Pages\CreateDonation;
use App\Filament\Resources\Donations\Pages\EditDonation;
use App\Filament\Resources\Donations\Pages\ListDonations;
use App\Filament\Resources\Donations\Schemas\DonationForm;
use App\Filament\Resources\Donations\Tables\DonationsTable;
use App\Models\Donation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;

    protected static ?string $recordTitleAttribute = 'donor_name';

    protected static ?int $navigationSort = 5;
    protected static string|\UnitEnum|null $navigationGroup = 'ادارةالحسابات ';
    // تسمية نموذج المورد
    protected static ?string $modelLabel = 'تبرع';
    // تسمية نموذج المورد بصيغة الجمع
    protected static ?string $pluralModelLabel = ' التبرعات';

    public static function form(Schema $schema): Schema
    {
        return DonationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DonationsTable::configure($table);
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
            'index' => ListDonations::route('/'),
            'create' => CreateDonation::route('/create'),
            'edit' => EditDonation::route('/{record}/edit'),
        ];
    }



       public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->select(['id', 'amount',  'date',  'donor_name',  'notes'])
            // ->with(['doctor:id,name'])
             ; // عرض 5 فقط;
    }
}
