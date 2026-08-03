<?php

namespace App\Filament\Resources\EmployeeAdvances\Tables;

use App\Models\EmployeeAdvance;
use App\Models\Expense;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmployeeAdvancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')->label('الموظف')->sortable()->searchable(),
                TextColumn::make('amount')->label('المبلغ')->numeric()->suffix(' ج.م')->sortable(),
                TextColumn::make('repaid_amount')->label('المسدد')->numeric()->suffix(' ج.م')->sortable(),
                TextColumn::make('date')->label('تاريخ السلفة')->date()->sortable(),
                TextColumn::make('due_date')->label('تاريخ الاستحقاق')->date()->sortable(),
                BadgeColumn::make('status')
                    ->label('الحالة')
                   ->formatStateUsing(fn (string $state): string => match ($state) {
                        'open' => 'مفتوحة',
                        'closed' => 'مسددة',
    })
                    ->colors([
                        'warning' => 'open',
                        'success' => 'closed',
                    ]),
                TextColumn::make('notes')->label('ملاحظات')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('repayAdvance')
                    ->label('سداد سلفة')
                    ->color('success')
                    ->visible(fn (EmployeeAdvance $record): bool => $record->status === 'open')
                    ->action(function (EmployeeAdvance $record) {
                        $remaining = $record->amount - $record->repaid_amount;
                        $record->update([
                            'repaid_amount' => $record->amount,
                            'status' => 'closed',
                        ]);

                        Expense::create([
                            'amount' => $remaining,
                            'date' => now()->toDateString(),
                            'category' => 'سلف موظفين',
                            'description' => "سداد سلفة {$record->employee->name}",
                        ]);

                        Notification::make()
                            ->title("تم سداد السلفة {$record->employee->name}")
                            ->body("المبلغ المسدد: {$remaining} ج.م")
                            ->success()
                            ->sendToDatabase(User::find(1), true);
                            // ->sendToDatabase(User::all(), true);
                            
                    }),
            ]);
    }
}
