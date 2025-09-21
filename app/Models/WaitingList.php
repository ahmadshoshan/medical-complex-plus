<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'room_id',
        'status',
        'queue_number',
        'arrival_time',
        'start_time',
        'end_time',
        'notes',

    ];

protected $casts = [
        'arrival_time' => 'datetime',
    ];

    // ⬅️ متغير لتخزين المبلغ مؤقتًا
    public static $temporaryAmount = null;

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // public function doctor()
    // {
    //     return $this->belongsTo(Doctor::class);
    // }
  public function doctor()
    {
        return $this->belongsTo(\App\Models\Doctor::class, 'doctor_id');
    }


    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function revenue()
    {
          return $this->hasOne(Revenue::class, 'waiting_lists_id');
    }

public function getRevenueAmountAttribute()
{
    return $this->revenue?->amount ?? 0;
}

    // protected $appends = ['revenue_amount'];

    // public function getRevenueAmountAttribute()
    // {
    //     return $this->revenue?->amount;
    // }
}
