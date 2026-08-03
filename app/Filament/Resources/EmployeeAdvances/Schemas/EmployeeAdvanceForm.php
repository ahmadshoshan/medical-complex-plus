<?php

namespace App\Filament\Resources\EmployeeAdvances\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EmployeeAdvanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->label('الموظف')
                    ->relationship('employee', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('amount')
                    ->label('المبلغ')
                    ->numeric()
                    ->required(),
                DatePicker::make('date')
                    ->label('تاريخ السلفة')
                    ->required()
                    ->default(now()),
                DatePicker::make('due_date')
                    ->label('تاريخ الاستحقاق')
                    ->nullable(),
                TextInput::make('repaid_amount')
                    ->label('المسدد')
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'open' => 'مفتوحة',
                        'closed' => 'مسددة',
                    ])
                    ->default('open')
                    ->required(),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
