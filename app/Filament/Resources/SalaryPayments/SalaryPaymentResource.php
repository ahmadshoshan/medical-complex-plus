<?php

namespace App\Filament\Resources\SalaryPayments;

use App\Filament\Resources\SalaryPayments\Pages\CreateSalaryPayment;
use App\Filament\Resources\SalaryPayments\Pages\EditSalaryPayment;
use App\Filament\Resources\SalaryPayments\Pages\ListSalaryPayments;
use App\Filament\Resources\SalaryPayments\Schemas\SalaryPaymentForm;
use App\Filament\Resources\SalaryPayments\Tables\SalaryPaymentsTable;
use App\Models\SalaryPayment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SalaryPaymentResource extends Resource
{
    protected static ?string $model = SalaryPayment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ViewfinderCircle;
    protected static string|\UnitEnum|null $navigationGroup = 'ادارة الحسابات';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'دفعة مرتب';
    }

    public static function getPluralModelLabel(): string
    {
        return 'دفعات المرتبات';
    }

    public static function form(Schema $schema): Schema
    {
        return SalaryPaymentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalaryPaymentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSalaryPayments::route('/'),
            'create' => CreateSalaryPayment::route('/create'),
            'edit' => EditSalaryPayment::route('/{record}/edit'),
        ];
    }
}
