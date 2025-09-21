<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Resources\Users\Pages\CreateUser;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return

            $schema

            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('username')
                ->unique()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()->unique()
                    ->required(),
                // DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required()

                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(Page $livewire) => ($livewire instanceof CreateUser)),

                Fieldset::make('permissions')
                ->columnSpanFull()
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                        'xl' => 3,
                    ])
                    ->schema([
                        Select::make('permissions')
                            ->multiple()
                            ->relationship('permissions', 'name')
                            ->preload(),
                        Select::make('rols')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload(),
                        Select::make('home_page')
                            ->label('الصفحة الافتراضية')
                            ->options([
                                '/admin' => 'لوحة التحكم',
                                '/admin/doctor-page' => ' لوحة التحكم الطبيب',
                                '/admin/users' => 'إدارة المستخدمين',
                                '/admin/doctors' => 'إدارة الأطباء',
                                '/admin/appointments' => 'المواعيد',
                                '/admin/t-v' => 'شاشة العرض',
                                '/admin/waiting-lists' => 'قائمة الانتظار',
                                // أضف صفحات أخرى حسب احتياجاتك
                            ])
                            ->nullable()
                            ->searchable()
                            ->helperText('سيتم تحويل المستخدم إلى هذه الصفحة بعد تسجيل الدخول'),

                    ]),
                // Section::make('الصلاحيات')
                //     ->schema([
                //         Select::make('roles')
                //             ->label('الأدوار')S
                //             ->multiple()
                //             ->searchable()
                //             ->preload()
                //             ->relationship('roles', 'name'),

                //         Select::make('permissions')
                //             ->label('الصلاحيات')
                //             ->multiple()
                //             ->searchable()
                //             ->preload()
                //             ->relationship('permissions', 'name'),
                //     ]),

                // TextColumn::make('roles.name')
                //     ->label('الدور')
                //     ->badge()
                //     ->color('success')
                //     ->separator(','),



            ]);
    }
}
