<?php

namespace App\Observers;

use App\Models\Purchase;
use App\Models\Expense;

class PurchaseObserver
{
    public function created(Purchase $Purchase)
    {
        if ($Purchase->price > 0) {
            Expense::create([
                'amount'       => $Purchase->price,
                'category'         => 'مشتريات',
                'date'         => $Purchase->Purchase_date ?? now()->toDateString(),
                'description'  => 'شراء  ' . ($Purchase->item ?? 'مجهول') . '- عدد القطع' . ($Purchase->quantity ?? ''),
                'm_id'  => $Purchase->id,
            ]);
        }
    }

    public function updated(Purchase $Purchase)
    {
        $Expense = Expense::where('category', 'مشتريات')
            ->where('m_id', $Purchase->id)->first();

        if ($Purchase->price > 0) {
            if ($Expense) {
                // تحديث الإيراد الموجود
                $Expense->update([
                    'amount'       => $Purchase->price,
                    'date'         => $Purchase->Purchase_date ?? now()->toDateString(),
                    'description'  => 'شراء  ' . ($Purchase->item ?? 'مجهول') . '- عدد القطع' . ($Purchase->quantity ?? ''),
                ]);
            } else {
                // لو مفيش إيراد مرتبط، نضيف واحد جديد
                Expense::create([
                    'amount'       => $Purchase->price,
                    'category'         => 'مشتريات',
                    'date'         => $Purchase->Purchase_date ?? now()->toDateString(),
                    'description'  => 'شراء  ' . ($Purchase->item ?? 'مجهول') . '- عدد القطع' . ($Purchase->quantity ?? ''),
                    'm_id'  => $Purchase->id,
                ]);
            }
        } else {
            // لو المبلغ صفر أو أقل نحذف الإيراد
            if ($Expense) {
                $Expense->delete();
            }
        }
    }

    public function deleted(Purchase $Purchase)
    {
        Expense::where('m_id', $Purchase->id)->delete();
    }
}
