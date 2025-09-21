<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('الاسم')
                    ->required(),
                TextInput::make('phone')->label(label: 'رقم الهاتف')
                    ->tel()
                    ->default(null),
                TextInput::make('position')->label('الوظيفة')
                    ->default(null),
                DatePicker::make('hire_date')->label('تاريخ التوظيف'),
                TextInput::make('salary')->label('الراتب')
                    ->numeric()
                    ->default(null),
                Select::make('user_id')
                    ->label('اسم المستخدم ')

                    ->relationship(
                        name: 'user',
                        titleAttribute: 'name',
                        // تعديل الاستعلام لجلب المستخدمين الذين ليس لديهم ملف طبيب فقط
                        // modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('doctor')
                    )
                    ->searchable()
                    ->preload()
                    // ->required()
                    ->createOptionForm([ // لإضافة مستخدم جديد مباشرة من هنا
                        TextInput::make('name')->required()->label('اسم'),
                        TextInput::make('email')->email()->required()->unique(User::class, 'email')->label('البريد الاكتروني'),
                        TextInput::make('password')->password()->required()->label('الرقم السري'),
                    ]),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
