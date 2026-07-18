<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')->label('المبلغ')
                    ->required()
                    ->numeric(),
              DatePicker::make('date')
    ->label('التاريخ')
    ->required()
    ->default(now())  // ✅ تاريخ اليوم تلقائياً
    ->displayFormat('d/m/Y')  // تنسيق التاريخ (اختياري)
    ->native(false),  // عرض التقويم بشكل أجمل (اختياري)
                // TextInput::make('category')->label('الفئة')
                //     ->required(),
              

                     Select::make('category')
                            ->label('الفئة')
                            ->required()
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('category')
                                    ->label('اسم الفئة')
                                    ->required(),
                            ])
                            ->createOptionUsing(function (array $data) {
                                return $data['category'];
                            })
                            ->options([
                                'فاتورة كهرباء' => '💡 فاتورة كهرباء',
                                'فاتورة مياه' => '💧 فاتورة مياه',
                                'فاتورة إنترنت' => '🌐 فاتورة إنترنت',
                                'فاتورة هاتف' => '📞 فاتورة هاتف',
                                'فاتورة غاز' => '🔥 فاتورة غاز',
                                'إيجار المبنى' => '🏠 إيجار المبنى',
                                'إيجار معدات' => '🏠 إيجار معدات',
                                'مرتبات وأجور' => '💰 مرتبات وأجور',
                                'سلف موظفين' => '💵 سلف موظفين',
                                'مكافآت' => '🎁 مكافآت',
                                'تأمينات اجتماعية' => '🛡️ تأمينات اجتماعية',
                                'أدوية ومستلزمات طبية' => '💊 أدوية ومستلزمات طبية',
                                'مستلزمات طبية قابلة للاستخدام' => '🩺 مستلزمات طبية',
                                'مواد تعقيم وتطهير' => '🧴 مواد تعقيم وتطهير',
                                'أدوات حماية شخصية' => '😷 أدوات حماية شخصية',
                                'مستلزمات مكتبية' => '🖨️ مستلزمات مكتبية',
                                'ورق طباعة' => '📄 ورق طباعة',
                                'أحبار وطونر' => '🖨️ أحبار وطونر',
                                'صيانة أجهزة طبية' => '🔧 صيانة أجهزة طبية',
                                'صيانة مبنى' => '🏗️ صيانة مبنى',
                                'صيانة أثاث' => '🪑 صيانة أثاث',
                                'صيانة مركبات' => '🚗 صيانة مركبات',
                                'خدمات تنظيف' => '🧹 خدمات تنظيف',
                                'خدمات حراسة' => '👮 خدمات حراسة',
                                'خدمات فنية' => '🔧 خدمات فنية',
                                'رسوم حكومية' => '📋 رسوم حكومية',
                                'تراخيص' => '📜 تراخيص',
                                'ضرائب' => '💼 ضرائب',
                                'رسوم بنكية' => '🏦 رسوم بنكية',
                                'عمولات' => '💳 عمولات',
                                'دعاية وإعلان' => '📢 دعاية وإعلان',
                                'تسويق إلكتروني' => '💻 تسويق إلكتروني',
                                'مطبوعات دعائية' => '📰 مطبوعات دعائية',
                                'نقل ومواصلات' => '🚗 نقل ومواصلات',
                                'وقود' => '⛽ وقود',
                                'ضيافة' => '☕ ضيافة',
                                'اجتماعات' => '🤝 اجتماعات',
                                'تدريب وتطوير' => '🎓 تدريب وتطوير',
                                'أخرى' => '📦 أخرى',
                            ])
                            ->native(false)
                            ->columnSpanFull(),
                              Textarea::make('description')->label('الوصف')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
