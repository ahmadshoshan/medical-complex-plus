<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model //تبرعات
{
    protected $fillable = ['amount','date', 'donor_name', 'notes'];

 public function revenue()
    {
        return $this->hasOne(Revenue::class);
    }



    //  // فورًا يتسجل في جدول الإيرادات كـ (تبرع).
    // protected static function booted()
    // {
    //     static::created(function ($donation) {
    //         // لو المبلغ > 0 ضيفه كإيراد
    //         if ($donation->amount > 0) {
    //             Revenue::create([
    //                 'amount'     => $donation['amount'],
    //                 'type'        => 'تبرع', // 👈 ضروري
    //                 'date'       => $data['date'] ?? now()->toDateString(), // هنا بنضيف التاريخ الحالي افتراضي                    'donor_name' => $donation['donor_name'] ?? null,
    //                 'description'      => ('من'.$donation['donor_name'] )?? ' من مجهول'.(' '.$donation['notes'] )?? null,

    //             ]);
    //         }
    //     });
    // }
}
