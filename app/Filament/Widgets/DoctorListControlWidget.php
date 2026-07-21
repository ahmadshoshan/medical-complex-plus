<?php



namespace App\Filament\Widgets;

use App\Events\CallPatient;
use App\Filament\Resources\WaitingLists\WaitingListResource as WaitingListsWaitingListResource;
use App\Models\WaitingList;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class DoctorListControlWidget extends BaseWidget

{
    // ✨ تغيير العنوان اللي بيظهر فوق الودجت
    protected static ?string $heading = 'قائمة الانتظار';
    protected ?string $pollingInterval = null;
    protected int | string | array $columnSpan = 'full';

    protected static bool $isDiscovered = false;
    public static function shouldRegisterNavigation(): bool
    {
        return false; // مش هيظهر في النافيجيشن
    }

    public function table(Table $table): Table
    {
        $doctorId = Auth::user()?->doctor?->id; // 🩺 دكتور اللي عامل لوجين

        return $table
            ->query(
                WaitingListsWaitingListResource::getEloquentQuery()
                    ->with(['doctor', 'room', 'patient', 'revenue'])
                    ->where('doctor_id', $doctorId) // ✅ عرض الحالات الخاصة بالدكتور فقط
            )

            ->columns([


                TextColumn::make('queue_number')->label('رقم ')->sortable(),
                TextColumn::make('patient.name')
                ->label('الاسم')->sortable()
                    // ✅ هذا السطر هو السحر: يظهر رقم الهاتف أسفل الحالة
    ->description(fn ($record) => '📞 ' . ($record->patient?->phone ?? 'غير متوفر'), position: 'below')
    
    ->sortable()
                ->searchable(),
                // TextColumn::make('patient.phone')->label('الهاتف')->sortable()->searchable(),
                 TextColumn::make('notes')
                    ->label('نوع الزيارة')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn($record) => $record->notes ?? 'غير محدد')
                    ->badge()
                    ->color(fn($state) => $state === 'غير محدد' ? 'gray' : 'primary'),

                TextColumn::make('doctor.name')->label('الطبيب')->sortable(),
               
                // TextColumn::make('room.room_number')->label('الغرفة'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'waiting' => 'في الانتظار',
                        'in_progress' => 'جاري الكشف',
                        'completed' => 'مكتمل',
                        'canceled' => 'ملغي',
                        default => ucfirst($state), // احتياطي
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'waiting' => 'warning',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'canceled' => 'danger',
                    }),
                TextColumn::make('arrival_time')
                    ->label('وقت الوصول')
                    ->time('i h A'),
                TextColumn::make('revenue.amount')
                    ->label('المبلغ')
                    ->numeric()
                    ->suffix(' ج.م')
                    ->sortable()

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
                    ->label('استدعاء التالي')
                    ->icon('heroicon-s-chevron-right')
                    ->color('success')
                    ->visible(fn(WaitingList $record): bool => $record->status === 'waiting')
                    ->action(function (WaitingList $record) {
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
                    })
                // ->requiresConfirmation(),
            ])



        ;
    }




    // داخل الكلاس
    protected $listeners = [
        'echo:waiting-list,WaitingListUpdated' => 'handleUpdate'
    ];

    #[On('echo:waiting-list,WaitingListUpdated')]
    public function handleUpdate($data)
    {
        $this->dispatch('refreshTable');
    }
}
