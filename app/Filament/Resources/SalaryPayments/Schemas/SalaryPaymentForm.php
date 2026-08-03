<?php

namespace App\Filament\Resources\SalaryPayments\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SalaryPaymentForm
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
                Select::make('month')
                    ->label('الشهر')
                    ->options([
                        1 => 'يناير',
                        2 => 'فبراير',
                        3 => 'مارس',
                        4 => 'أبريل',
                        5 => 'مايو',
                        6 => 'يونيو',
                        7 => 'يوليو',
                        8 => 'أغسطس',
                        9 => 'سبتمبر',
                        10 => 'أكتوبر',
                        11 => 'نوفمبر',
                        12 => 'ديسمبر',
                    ])
                    ->required()
                    ->default(now()->month),
                TextInput::make('year')
                    ->label('السنة')
                    ->numeric()
                    ->required()
                    ->default(now()->year),
                TextInput::make('amount')
                    ->label('الراتب')
                    ->numeric()
                    ->required(),
                TextInput::make('deduction')
                    ->label('الخصومات')
                    ->numeric()
                    ->default(0),
                TextInput::make('advance_repayment')
                    ->label('سداد السلفة')
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'paid' => 'مدفوعة',
                    ])
                    ->default('pending')
                    ->required(),
                DatePicker::make('paid_at')
                    ->label('تاريخ الدفع')
                    ->nullable(),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
