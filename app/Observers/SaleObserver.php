<?php

namespace App\Observers;

use App\Models\Sale;
use App\Models\Revenue;

class SaleObserver
{
    public function created(Sale $Sale)
    {


        if ($Sale->price > 0) {
            Revenue::create([
                'amount'       => $Sale->price,
                'type'         => 'مبيعات',
                'date'         => $Sale->sale_date ?? now()->toDateString(),
                'description'  => 'بيع  ' . ($Sale->item ?? 'مجهول') . '- عدد القطع' . ($Sale->quantity ?? ''),
                'm_id'  => $Sale->id,
            ]);
        }
    }

    public function updated(Sale $Sale)
    {
        $revenue = Revenue::where('type', 'مبيعات')
            ->where('m_id', $Sale->id)->first();

        if ($Sale->price > 0) {
            if ($revenue) {
                // تحديث الإيراد الموجود
                $revenue->update([
                    'amount'       => $Sale->price,
                    'date'         => $Sale->sale_date ?? now()->toDateString(),
                    'description'  => 'بيع  ' . ($Sale->item ?? 'مجهول') . '- عدد القطع' . ($Sale->quantity ?? ''),
                ]);
            } else {
                // لو مفيش إيراد مرتبط، نضيف واحد جديد
                Revenue::create([
                    'amount'       => $Sale->price,
                    'type'         => 'مبيعات',
                    'date'         => $Sale->sale_date ?? now()->toDateString(),
                    'description'  => 'بيع  ' . ($Sale->item ?? 'مجهول') . '- عدد القطع' . ($Sale->quantity ?? ''),
                    'm_id'  => $Sale->id,
                ]);
            }
        } else {
            // لو المبلغ صفر أو أقل نحذف الإيراد
            if ($revenue) {
                $revenue->delete();
            }
        }
    }

    public function deleted(Sale $Sale)
    {
        Revenue::where('m_id', $Sale->id)->delete();
    }
}
