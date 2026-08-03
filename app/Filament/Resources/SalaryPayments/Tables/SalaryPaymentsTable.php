<?php

namespace App\Filament\Resources\SalaryPayments\Tables;

use App\Models\Expense;
use App\Models\SalaryPayment;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SalaryPaymentsTable
{

    private const MONTHS = [
        1 => 'يناير',
        2 => 'فبراير',
        3 => 'مارس',
        4 => 'أبريل',
        5 => 'مايو',
        6 => 'يونيو',
        7 => 'يوليو',
        8 => 'أغسطس',
        9 => 'سبتمبر',
        10 => 'أكتوبر',
        11 => 'نوفمبر',
        12 => 'ديسمبر',
    ];
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')->label('الموظف')->sortable()->searchable(),
                TextColumn::make('month')
                    ->label('الشهر')
                                      ->formatStateUsing(fn ($state): string => self::MONTHS[(int) $state] ?? 'غير محدد')

                    ->sortable(),
                TextColumn::make('year')->label('السنة')->sortable(),
                TextColumn::make('amount')->label('الراتب')->numeric()->suffix(' ج.م')->sortable(),
                TextColumn::make('deduction')->label('الخصم')->numeric()->suffix(' ج.م')->sortable(),
                TextColumn::make('advance_repayment')->label('سداد السلفة')->numeric()->suffix(' ج.م')->sortable(),
                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'قيد الانتظار',
                        'paid' => 'مدفوعة',
                    })
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                    ]),
                TextColumn::make('paid_at')->label('تاريخ الدفع')->dateTime()->sortable(),
                TextColumn::make('created_at')->label('تاريخ الإنشاء')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('paySalary')
                    ->label('دفع الراتب')
                    ->color('success')
                    ->visible(fn (SalaryPayment $record): bool => $record->status === 'pending')
                    ->action(function (SalaryPayment $record) {
                        $paidAmount = max(0, $record->amount - $record->deduction - $record->advance_repayment);

                        Expense::create([
                            'amount' => $paidAmount,
                            'date' => now()->toDateString(),
                            'category' => 'مرتبات وأجور',
                            'description' => "دفع مرتب {$record->employee->name} لشهر {$record->month}/{$record->year}",
                        ]);

                        $record->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        Notification::make()
                            ->title("تم دفع راتب {$record->employee->name}")
                            ->body("المبلغ المدفوع: {$paidAmount} ج.م")
                            ->success()
                            ->sendToDatabase(User::all(), true);
                    }),
            ]);
    }
}
