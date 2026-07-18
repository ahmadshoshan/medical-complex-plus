<?php

namespace App\Filament\Resources\WaitingLists\Tables;

use App\Events\CallPatient;
use App\Models\WaitingList;
use Filament\Actions\Action;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Livewire\Component;

class WaitingListsTable extends Component
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc') // ✅ الأفضل ترتيب حسب الأحدث (أو doctor.name حسب رغبتك)
              // ✅ أضف هذا السطر لتحميل العلاقات مسبقاً وتسريع الجدول بشكل هائل
     // ✅ هذا هو السطر الصحيح والآمن 100%
->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => 
    $query->with(['patient', 'doctor', 'room', 'revenue'])
)
            ->columns([
                TextColumn::make('queue_number')
                    ->label('رقم')
                    ->sortable()
                    ->color(function ($record) {
                        return match (optional($record)->status) {
                            'waiting' => 'secondary',
                            'in_progress' => 'info',
                            'completed' => 'success',
                            'canceled' => 'danger',
                            default => 'secondary',
                        };
                    }),

                    TextColumn::make('patient.name')
                    ->label('الاسم')
                    ->sortable()
                    ->searchable()
                    ->color(function ($record) {
                        return match (optional($record)->status) {
                            'waiting' => 'secondary',
                            'in_progress' => 'info',
                            'completed' => 'success',
                            'canceled' => 'danger',
                            default => 'secondary',
                        };
                    }),

TextColumn::make('notes')
    ->label('نوع الزيارة')
    ->sortable()
    ->searchable()
    ->getStateUsing(fn ($record) => $record->notes ?? 'غير محدد')
    ->badge()
    ->color(fn ($state) => $state === 'غير محدد' ? 'gray' : 'primary'),

                TextColumn::make('doctor.name')
                    ->label('الطبيب')
                    ->sortable()
                    ->color(function ($record) {
                        return match (optional($record)->status) {
                            'waiting' => 'secondary',
                            'in_progress' => 'info',
                            'completed' => 'success',
                            'canceled' => 'danger',
                            default => 'secondary',
                        };
                    }),

                TextColumn::make('room.room_number')
                    ->label('الغرفة')
                    ->sortable()
                    ->badge()
                    ->color(fn($record) => match ($record->room?->room_number) {
                        '1' => 'success',
                        '2' => 'info',
                        '3' => 'warning',
                        '4' => 'danger',
                        '5' => 'purple',
                        '6' => 'gray',
                        default => 'secondary',
                    }),

                SelectColumn::make('status')
                    ->label('الحالة')
                    ->options([
                        'waiting' => 'في الانتظار',
                        'in_progress' => 'جاري الكشف',
                        'completed' => 'مكتمل',
                        'canceled' => 'ملغي',
                    ])
                    ->disabled(fn($record) => $record->status === 'canceled')
                    ->updateStateUsing(function (WaitingList $record, $state): void {
                        $record->update(['status' => $state]);
                        if ($state === 'canceled' && $record->revenue) {
                            $record->revenue->update(['amount' => 0]);
                        }
                    }),

                TextColumn::make('arrival_time')
                    ->label('وقت الوصول')
                    ->time('h:i A') // ✅ تنسيق الوقت بشكل صحيح (ساعات:دقائق صباحاً/مساءً)
                    ->color(function ($record) {
                        return match (optional($record)->status) {
                            'waiting' => 'secondary',
                            'in_progress' => 'info',
                            'completed' => 'success',
                            'canceled' => 'danger',
                            default => 'secondary',
                        };
                    }),

                TextColumn::make('revenue.amount')
                    ->label('المبلغ')
                    ->numeric()
                    ->suffix(' ج.م')
                    ->sortable()
                    ->color(fn($record) => ($record->revenue?->amount ?? 0) == 0 ? 'danger' : 'success')
                    ->summarize([
                        Sum::make()
                            ->label('الإجمالي')
                            ->numeric()
                            ->suffix(' ج.م')
                    ]),
            ])
            ->filters([
                \Filament\Tables\Filters\Filter::make('by_date')
                    ->label('تاريخ')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_at')
                            ->default(fn() => now())
                            ->label('اختر التاريخ'),
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['created_at'])) {
                            $query->whereDate('created_at', $data['created_at'])
                                  ->with('revenue', 'patient', 'doctor', 'room'); // ✅ تحسين الأداء بتحميل العلاقات
                        }
                    })
            ])
            ->recordActions([
                Action::make('call_next')
                    ->label(fn(WaitingList $record): string => self::check_receptionist_call($record) ? 'استدعاء التالي' : 'غير مسموح')
                    ->icon('heroicon-s-chevron-right')
                    ->color(fn(WaitingList $record): string => self::check_receptionist_call($record) ? 'success' : 'warning')
                    ->visible(fn(WaitingList $record): bool => $record->status === 'waiting')
                    ->action(function (WaitingList $record) {
                        $doctor = $record->doctor;
                        if ($doctor?->allow_receptionist_call) {
                            // إقفال أي مريض جاري الكشف عند نفس الطبيب
                            WaitingList::where('doctor_id', $record->doctor_id)
                                ->where('status', 'in_progress')
                                ->update(['status' => 'completed']);

                            // تحديث حالة المريض الحالي
                            $record->update(['status' => 'in_progress']);

                            $patientNumber = $record->queue_number ?? 0;
                            $roomNumber = $record->room?->room_number ?? 0;
                            $doctorName = $record->patient?->name ?? '';
                            $doctorSpecialty = $record->doctor?->specialty ?? '';

                            event(new CallPatient($patientNumber, $roomNumber, $doctorName, $doctorSpecialty));
                        }
                    }),

                Action::make('print')
                    ->label('طباعة')
                    ->icon('heroicon-o-printer')
                    ->url(fn($record) => route('waiting-list.print', $record))
                    ->visible(fn($record) => optional($record)->status === 'waiting')
                    ->openUrlInNewTab(),
            ]);
    }

    public static function check_receptionist_call(WaitingList $record): bool
    {
        return $record->doctor?->allow_receptionist_call ?? false;
    }
}