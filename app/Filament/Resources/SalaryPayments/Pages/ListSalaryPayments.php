<?php

namespace App\Filament\Resources\SalaryPayments\Pages;

use App\Filament\Resources\SalaryPayments\SalaryPaymentResource;
use App\Models\Expense;
use App\Models\SalaryPayment;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListSalaryPayments extends ListRecords
{
    protected static string $resource = SalaryPaymentResource::class;
 
    protected function getHeaderActions(): array
    {
        return [ 
            CreateAction::make(),
            Action::make('payPendingSalaries')
                ->label('دفع كل المرتبات المعلقة')
                ->color('success')
                ->action(function () {
                    $pending = SalaryPayment::where('status', 'pending')->get();
                    $paidCount = 0;

                    foreach ($pending as $payment) {
                        $paidAmount = max(0, $payment->amount - $payment->deduction - $payment->advance_repayment);

                        Expense::create([
                            'amount' => $paidAmount,
                            'date' => now()->toDateString(),
                            'category' => 'مرتبات وأجور',
                            'description' => "دفع مرتب {$payment->employee->name} لشهر {$payment->month}/{$payment->year}",
                        ]);

                        $payment->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        $paidCount++;
                    }

                    if ($paidCount > 0) {
                        Notification::make()
                            ->title('تم دفع المرتبات المعلقة')
                            ->body("تم دفع {$paidCount} مرتبًا")
                            ->success()
                            ->sendToDatabase(User::all(), true);
                    }
                }),
        ];
    }

}
