<?php

namespace App\Filament\Resources\WaitingLists\Tables;


use App\Events\CallPatient;

use App\Models\WaitingList;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Livewire\Attributes\On;
use Livewire\Component;

class WaitingListsTable extends Component
{


    public static function configure(Table $table): Table
    {

        return $table
            ->defaultSort('doctor.name', 'asc') // ✅ الترتيب حسب اسم الطبيب
            //   ->modifyQueryUsing(fn($query) => $query->where('status', '!=', 'canceled'))
            ->columns([


                TextColumn::make('queue_number')->label('رقم ')->sortable()


                    ->color(function ($record) {
                        return optional($record->revenue)->amount == 0 ? 'danger' : 'secondary';
                    }),
                TextColumn::make('patient.name')->label('الاسم')->sortable()->searchable()
                      ->color(function ($record) {
                        return optional($record->revenue)->amount == 0 ? 'danger' : 'secondary';
                    }),
                TextColumn::make('patient.phone')->label('الهاتف')->sortable()->searchable()
                      ->color(function ($record) {
                        return optional($record->revenue)->amount == 0 ? 'danger' : 'secondary';
                    }),
                TextColumn::make('doctor.name')->label('الطبيب')->sortable()
                      ->color(function ($record) {
                        return optional($record->revenue)->amount == 0 ? 'danger' : 'secondary';
                    }),
                TextColumn::make('room.room_number')
                    ->label('الغرفة')
                    ->sortable()
                    ->badge() // عشان يظهر كلون ملون
                    ->color(fn($record) => match ($record->room?->room_number) {
                        '1' => 'success',   // أخضر
                        '2' => 'info',      // أزرق
                        '3' => 'warning',   // أصفر
                        '4' => 'danger',    // أحمر
                        '5' => 'purple',    // بنفسجي (أو ممكن تستخدم primary)
                        '6' => 'gray',      // رمادي
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

                    ->disabled(fn($record) => $record->status === 'canceled') // ✅ هنا التعديل الصح
                    ->updateStateUsing(function (WaitingList $record, $state): void {
                        // 1. تحديث الحالة
                        $record->update(['status' => $state]);
                        // 🟥 لو الحالة الجديدة "ملغي" يتم تصفير المبلغ
                        if ($state === 'canceled') {
                            if ($record->revenue) {
                                $record->revenue->update(['amount' => 0]);
                            }
                        }
                    }),
                TextColumn::make('arrival_time')
                    ->label('وقت الوصول')
                    ->time('i h A')
                        ->color(function ($record) {
                        return optional($record->revenue)->amount == 0 ? 'danger' : 'secondary';
                    }),
                TextColumn::make('revenue.amount')
                    ->label('المبلغ')
                    ->numeric()
                    ->suffix(' ج.م')
                    ->sortable()
                    ->color(fn($record) => $record->revenue->amount == 0 ? 'danger' : 'success')
                    ->summarize([
                        Sum::make()
                            ->label('إجمالي المبالغ')
                            ->numeric()
                            ->suffix(' ج.م')

                    ])



            ])
            ->filters([
                \Filament\Tables\Filters\Filter::make('by_date')
                    ->label('تاريخ ')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_at')
                            ->default(fn() => now())
                            ->label('اختر التاريخ'),
                    ])

                    ->query(function ($query, array $data) {
                        if ($data['created_at']) {
                            $query->whereDate('created_at', $data['created_at'])
                                ->with('revenue'); // ✅ تحميل العلاقة داخل الفلتر;
                            // dd($query);
                        }
                    })
            ])

            ->recordActions([




                Action::make('call_next')
                    ->label(
                        fn(WaitingList $record): string =>
                        self::check_receptionist_call($record) ? 'استدعاء التالي' : 'غير مسموح'
                    )
                    ->icon('heroicon-s-chevron-right')
                    ->color(fn(WaitingList $record): string => self::check_receptionist_call($record) ? 'success' : 'warning')
                    ->visible(fn(WaitingList $record): bool => $record->status === 'waiting')


                    ->action(function (WaitingList $record) {
                        $doctor = $record->doctor;
                        if ($doctor->allow_receptionist_call) {


                            // ✨ أولاً: إقفال أي مريض جاري الكشف عند نفس الطبيب
                            WaitingList::where('doctor_id', $record->doctor_id)
                                ->where('status', 'in_progress')
                                ->update(['status' => 'completed']);

                            // ✨ بعدين: تحديث حالة المريض الحالي إلى جاري الكشف
                            $record->update([
                                'status' => 'in_progress',
                            ]);





                            $patientNumber = $record->queue_number ?? 0;
                            $roomNumber = $record->room->room_number ?? 0;
                            $doctorName = $record->patient->name ?? '';
                            $doctorSpecialty = $record->doctor->specialty ?? '';


                            // إطلاق الحدث
                            event(new CallPatient(
                                $patientNumber,
                                $roomNumber,
                                $doctorName,
                                $doctorSpecialty
                            ));
                        }
                    }),
                // ->requiresConfirmation(),
                // EditAction::make(),
                Action::make('print')
                    ->label('')
                    ->icon('heroicon-o-printer')
                    ->url(fn($record) => route('waiting-list.print', $record))
                       ->visible(fn($record) => optional($record->revenue)->amount > 0),
                    // ->openUrlInNewTab()



            ])
        ;
    }


    public static function check_receptionist_call(WaitingList $record): bool
    {
        $doctor = $record->doctor;
        if (!$doctor->allow_receptionist_call) {
            return false;
        }
        return true;
    }
}
