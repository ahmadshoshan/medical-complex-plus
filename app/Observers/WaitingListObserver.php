<?php

namespace App\Observers;

use App\Models\Revenue;
use App\Models\WaitingList;
use Filament\Notifications\Notification;

class WaitingListObserver
{
    public function created(WaitingList $waitingList)
    {

        $amount = WaitingList::$temporaryAmount;
        // dd($amount);
        if ($amount && $amount > 0) {
            Revenue::create([
                'amount' => $amount,
                'date' => now()->toDateString(),
                'type' => 'كشف',
                // 'description' => "الحالة /   {$waitingList->patient->name}  --الطبيب / {$waitingList->doctor->name}  ",
                'patient_id' => $waitingList->patient_id,
                'doctor_id' => $waitingList->doctor_id,
                'waiting_lists_id' => $waitingList->id,
            ]);
        }
        // (اختياري) امسح القيمة بعد الاستخدام
        WaitingList::$temporaryAmount = null;

        $this->broadcast();
    }
    public function updated(WaitingList $waitingList)
    {
        // // (اختياري) إذا تم تعديل المبلغ لاحقًا
        // // يمكنك تحديث أو إنشاء الإيراد
        // $revenue = $waitingList->revenue;
        // $amount = WaitingList::$temporaryAmount;
        // // dd($amount ,$revenue );

        // if ($amount && $amount > 0) {
        //     if ($revenue) {

        //         $revenue->update([
        //             'amount' => $amount,
        //             'description' => "كشف محدّث لـ {$waitingList->patient->name}",
        //             'patient_id' => $waitingList->patient_id,
        //             'doctor_id' => $waitingList->doctor_id,
        //             'waiting_lists_id' => $waitingList->id,
        //         ]);
        //         Notification::make()
        //             ->title(' تم تحديث ايراد'  . $amount . 'ج.م')
        //             ->info()
        //             ->send();
        //     } else {

        //         Revenue::create([
        //             'amount' => $amount,
        //             'date' => now()->toDateString(),
        //             'type' => 'كشف',
        //             'description' => "كشف لـ {$waitingList->patient->name}",
        //             'patient_id' => $waitingList->patient_id,
        //             'doctor_id' => $waitingList->doctor_id,
        //             'waiting_lists_id' => $waitingList->id,
        //         ]);
        //         Notification::make()
        //             ->title('تم انشاء ايراد' . $amount . 'ج.م')
        //             ->success()
        //             ->send();
        //         // dd('create');
        //     }
        // } elseif ($revenue) {

        //     // إذا تم حذف المبلغ، احذف الإيراد (أو علّقه)
        //     $revenue->delete();
        //     Notification::make()
        //         ->title(' تم حذف ايراد' . $amount . 'ج.م')
        //         ->warning()
        //         ->send();
        // }

        // // (اختياري) امسح القيمة بعد الاستخدام
        // WaitingList::$temporaryAmount = null;


        $this->broadcast();
    }
    public function deleted(WaitingList $WaitingList)
    {
        // (اختياري) حذف الإيراد المرتبط عند حذف قائمة الانتظار
        if ($WaitingList->revenue_id) {
            Revenue::where('id', $WaitingList->revenue_id)->delete();
        }
        $this->broadcast();
    }

    protected function broadcast()
    {
        \App\Events\StatsUpdated::dispatch();
        \App\Events\WaitingListUpdated::dispatch();
    }
}
