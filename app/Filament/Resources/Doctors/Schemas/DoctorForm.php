<?php

namespace App\Filament\Resources\Doctors\Schemas;

use App\Models\Doctor;
use App\Models\User;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
        

            ->components([
                TextInput::make('name')
                    ->label('الاسم')
                    ->required(),
                Select::make('user_id')
                    ->label('اسم المستخدم')

                    ->relationship(
                        name: 'user',
                        titleAttribute: 'username',
                        // تعديل الاستعلام لجلب المستخدمين الذين ليس لديهم ملف طبيب فقط
                        // modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('doctor')
                    )
                    ->searchable()

                    ->createOptionForm([ // لإضافة مستخدم جديد مباشرة من هنا
                        TextInput::make('name')
                            ->required()->label('اسم'),
                        // ->default(function ($livewire) {
                        //     // $livewire هنا هو المكون الرئيسي (مثلاً CreateWaitingList أو EditWaitingList)
                        //     return $livewire->mountedRecord?->name ?? $livewire->form->getState()['name'] ?? null;
                        // }),
                        TextInput::make('username')->required()->label('اسم المستخدم')->unique(User::class, 'username'),
                        TextInput::make('email')->email()->required()->unique(User::class, 'email')->label('البريد الاكتروني'),
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->confirmed() // 👈 هذا يتحقق من وجود حقل 'password_confirmation' ويقارنهم
                            ->label('الرقم السري'),

                        TextInput::make('password_confirmation')
                            ->password()
                            ->required()
                            ->label('تأكيد الرقم السري'),
                    ]),
                TextInput::make('specialty')->label('التخصص')
                    ->required(),
                TextInput::make('phone')->label('الهاتف')
                    ->tel()
                    ->required(),
                Textarea::make('bio')->label('نبذة تعريفية')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_active')->label('نشط')
                    ->default(true)
                    ->required(),
            ]);
    }
}
