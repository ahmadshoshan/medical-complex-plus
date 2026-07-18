<?php

namespace App\Observers;

use App\Models\Donation;
use App\Models\Revenue;

class DonationObserver
{
    public function created(Donation $donation)
    {
        if ($donation->amount > 0) {
            Revenue::create([
                'amount'       => $donation->amount,
                'type'         => 'تبرع',
                'date'         => $donation->date ?? now()->toDateString(),
                'description'  => 'تبرع من ' . ($donation->donor_name ?? 'مجهول') . '-' . ($donation->notes ?? ''),
                'donation_id'  => $donation->id,
            ]);
        }
    }

    public function updated(Donation $donation)
    {
        $revenue = Revenue::where('donation_id', $donation->id)->first();

        if ($donation->amount > 0) {
            if ($revenue) {
                // تحديث الإيراد الموجود
                $revenue->update([
                    'amount'       => $donation->amount,
                    'date'         => $donation->date ?? now()->toDateString(),
                    'description'  => 'تبرع من ' . ($donation->donor_name ?? 'مجهول') . ' ' . ($donation->notes ?? ''),
                ]);
            } else {
                // لو مفيش إيراد مرتبط، نضيف واحد جديد
                Revenue::create([
                    'amount'       => $donation->amount,
                    'type'         => 'تبرع',
                    'date'         => $donation->date ?? now()->toDateString(),
                    'description'  => 'تبرع من ' . ($donation->donor_name ?? 'مجهول') . ' ' . ($donation->notes ?? ''),
                    'donation_id'  => $donation->id,
                ]);
            }
        } else {
            // لو المبلغ صفر أو أقل نحذف الإيراد
            if ($revenue) {
                $revenue->delete();
            }
        }
    }

    public function deleted(Donation $donation)
    {
        Revenue::where('donation_id', $donation->id)->delete();
    }
}
