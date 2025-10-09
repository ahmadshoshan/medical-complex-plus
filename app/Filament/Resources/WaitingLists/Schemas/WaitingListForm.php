<?php

namespace App\Filament\Resources\WaitingLists\Schemas;

use App\Models\Doctor;
use App\Models\Room;
use App\Models\WaitingList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WaitingListForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('patient_id')
                    ->label('الاسم')
                    ->relationship('patient', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->createOptionForm([ // ⬅️ استخدم createOptionForm
                        TextInput::make('name')
                            ->label('الاسم')
                            ->required(),
                        TextInput::make('national_id') // ✅ الرقم القومي
                            ->label('الرقم القومي')
                            ->numeric()
                            ->minLength(14)
                            ->maxLength(14),
                        Select::make('gender')
                            ->label('النوع')
                            ->options(['male' => 'ذكر', 'female' => 'أنثى']),
                        TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel(),

                        DatePicker::make('birth_date')
                            ->label('تاريخ الميلاد'),

                    ])->createOptionUsing(function (array $data) {
                        // إنشاء المريض الجديد وترجيع الـ ID
                        return \App\Models\Patient::create($data)->id;
                    }),




                // Select::make('doctor_id')
                //     ->label('الطبيب')
                //     ->relationship('doctor', 'name')
                //     ->preload()
                //     ->searchable()
                //     ->required()
                //     ->reactive()
                // ->afterStateUpdated(function (callable $set, $state) {
                //     $doctor = \App\Models\Room::find(id: $state);
                //     dd($state);
                //     // if ($doctor && $doctor->room) {
                //     //     $set('room_id', $doctor->room->id);
                //     // }
                // })
                // ,
                // Select::make('room_id')
                //     ->label('الغرفة')
                //     ->relationship('room', 'room_number')->preload()
                //     ->searchable()
                //     ->required(),
                Select::make('doctor_id')
                    ->label('الطبيب')
                    ->relationship(
                        name: 'doctor',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn($query) => $query->has('room') // فقط الأطباء الذين لهم غرفة
                    )
                    ->preload()
                    ->searchable()
                    ->required()
                    ->reactive() // مهم: لتفعيل afterStateUpdated
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        // استرجاع الغرفة المرتبطة بالطبيب
                        $doctor  = Doctor::find($state);
                        if ($doctor && $doctor->room) {
                            // dd($doctor->room->room_number,$state);
                            $set('room_id', $doctor->room->id);
                        }

                          // 🟢 تحديث رقم الانتظار تلقائيًا للطبيب المحدد
        if ($state) {
            $today = now()->startOfDay();
            $lastRecordToday =WaitingList::query()
                ->where('doctor_id', $state)
                ->whereDate('created_at', $today)
                ->orderByDesc('queue_number')
                ->first();

            $nextQueue = $lastRecordToday ? $lastRecordToday->queue_number + 1 : 1;
            $set('queue_number', $nextQueue);
        } else {
            $set('queue_number', 1);
        }
                    })
                    ->live(), // أو reactive() يكفي، لكن live() أوضح في الإصدارات الحديثة

                Select::make('room_id')
                    ->label('الغرفة')
                    ->relationship('room', 'room_number')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->disabled() // لا يمكن تغييره يدويًا
                    ->dehydrated(true) // لحفظ القيمة حتى لو كان الحقل معطلًا
                    ->helperText('تم تحديد الغرفة تلقائيًا حسب الطبيب.'),
                DateTimePicker::make('arrival_time')
                    ->label('وقت الوصول')
                    ->required()
                    ->visible(fn($livewire) => !$livewire->record) // يظهر فقط عند الإنشاء
                    ->default(fn() => now())
                    ->disabled()->hidden(),

                TextInput::make('queue_number')
                    ->label('رقم الانتظار')
                    ->required()
                    ->numeric()
 ->reactive()
                    ->minValue(1)
                    ->default(function (callable $get) {
                        // $lasrRecord = WaitingList::query()->latest('queue_number')->first();
                        // return  $lasrRecord ? $lasrRecord->queue_number + 1 : 1;

                        $doctorId = $get('doctor_id'); // الحصول على الطبيب المختار
                        if (!$doctorId) {
                            return 1; // في حال لسه الطبيب ما اختارش
                        }

                        $today = now()->startOfDay(); // بداية اليوم
                        // جلب آخر رقم انتظار لنفس الطبيب في نفس اليوم
                        $lastRecordToday = WaitingList::query()
                            ->where('doctor_id', $doctorId)
                            ->whereDate('created_at', $today)
                            ->orderByDesc('queue_number')
                            ->first();

                        return $lastRecordToday ? $lastRecordToday->queue_number + 1 : 1;
                    }),


                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'waiting' => 'في الانتظار',
                        'in_progress' => 'جاري الكشف',
                        'completed' => 'مكتمل',
                        'canceled' => 'ملغي',
                    ])->default('waiting')->disabled()
                    ->required()->hidden(),


                TextInput::make('amount')
                    ->label('المبلغ (للإيراد)')
                    ->numeric()
                    ->minValue(0)
                    ->step(0.5)
                    ->suffix(' ج.م')
                    ->helperText('إذا أدخلت مبلغًا، سيتم إنشاء إيراد تلقائيًا')
                    ->visible(fn($livewire) => !$livewire->record), // يظهر فقط عند الإنشاء,
            ])



            ->columns(2)
            ->statePath('data');
    }
}
