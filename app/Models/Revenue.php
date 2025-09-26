<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model //الايرادات
{
    protected $fillable = [
        'amount',
        'date',
        'type',
        'description',
        'patient_id',
        'doctor_id',
        'waiting_lists_id',
       'donation_id', // 👈 أضفنا العمود
       'm_id', // 👈 أضفنا العمود
    ];


    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function waitingList()
    {
        return $this->belongsTo(WaitingList::class, 'waiting_lists_id');
    }
   public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
    // تحويل نوع الإيراد إلى عربي
    public function getTypeArAttribute()
    {
        return match ($this->type) {
            'كشف' => 'كشف',
            'إجراء' => 'إجراء',
            'تبرع' => 'تبرع',
            'اخرا' => 'اخرا',
            default => ucfirst($this->type),
        };
    }



}
