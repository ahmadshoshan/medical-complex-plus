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
            ->columns([


                TextColumn::make('queue_number')->label('رقم ')->sortable(),
                TextColumn::make('patient.name')->label('الاسم')->sortable()->searchable(),
                TextColumn::make('patient.phone')->label('الهاتف')->sortable()->searchable(),
                TextColumn::make('doctor.name')->label('الطبيب')->sortable(),
                TextColumn::make('room.room_number')->label('الغرفة'),
                SelectColumn::make('status')
                    ->label('الحالة')
                    ->options([
                        'waiting' => 'في الانتظار',
                        'in_progress' => 'جاري الكشف',
                        'completed' => 'مكتمل',
                        'canceled' => 'ملغي',
                    ])

                    ->updateStateUsing(function (WaitingList $record, $state): void {
                        // 1. تحديث الحالة
                        $record->update(['status' => $state]);
                    }),
                TextColumn::make('arrival_time')
                    ->label('وقت الوصول')
                    ->time('i h A'),
                TextColumn::make('revenue.amount')
                    ->label('المبلغ')
                    ->numeric()
                    ->suffix(' ج.م')
                    ->sortable()
                    // ->summarize([
                    //     Sum::make()
                    //         ->label('إجمالي المبالغ')
                    //         // ->numeric()
                    //         ->suffix(' ج.م')
                    //          ->inverseRelationship('waitingList') ,// 👈 هنا حددنا العلاقة,
                    // ])

                    // ->summarize(Sum::make()->label('إجمالي المبالغ')->numeric())
                    ->summarize([
                        Sum::make()
                            ->label('إجمالي المبالغ')
                            ->numeric()
                            ->suffix(' ج.م'),
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
                            $doctorName = $record->doctor->name ?? '';
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
                    ->openUrlInNewTab(),



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
