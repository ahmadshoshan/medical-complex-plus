<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;

class MedicalHistoryRelationManager extends RelationManager
{
    // اسم العلاقة في Model المريض
    protected static string $relationship = 'waitingLists';

    protected static ?string $title = 'السجل الطبي والزيارات';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('queue_number')
            // ✅ تحسين الأداء: جلب العلاقات مسبقاً
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['doctor', 'room', 'revenue']))
            ->columns([
                TextColumn::make('created_at')
                    ->label('تاريخ الزيارة')
                    ->date('Y-m-d')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('doctor.name')
                    ->label('الطبيب')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('doctor.specialty')
                    ->label('التخصص')
                    ->toggleable(isToggledHiddenByDefault: true), // يمكن إظهاره من إعدادات الجدول
                    
                TextColumn::make('room.room_number')
                    ->label('الغرفة')
                    ->badge()
                    ->color('info'),
                    
                TextColumn::make('notes')
                    ->label('نوع الزيارة / التشخيص')
                    ->default('غير محدد')
                    ->limit(30),
                    
                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'waiting' => 'في الانتظار',
                        'in_progress' => 'جاري الكشف',
                        'completed' => 'مكتمل',
                        'canceled' => 'ملغي',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'waiting' => 'warning',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'canceled' => 'danger',
                        default => 'gray',
                    }),
                    
                TextColumn::make('revenue.amount')
                    ->label('المبلغ المدفوع')
                    ->numeric()
                    ->suffix(' ج.م')
                    ->default(0)
                    ->color(fn($record) => ($record->revenue?->amount ?? 0) > 0 ? 'success' : 'danger')
                    ->sortable(),
                    
                TextColumn::make('arrival_time')
                    ->label('وقت الوصول')
                    ->time('h:i A'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'waiting' => 'في الانتظار',
                        'in_progress' => 'جاري الكشف',
                        'completed' => 'مكتمل',
                        'canceled' => 'ملغي',
                    ]),
                    
                Tables\Filters\Filter::make('date_range')
                    ->label('فترة زمنية')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('من تاريخ'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn(Builder $query, $date) => $query->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn(Builder $query, $date) => $query->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}