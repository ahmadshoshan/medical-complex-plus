<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
       protected $fillable = ['room_number', 'doctor_id', 'description'];

    public function doctor()
{
   return $this->belongsTo(Doctor::class); // ✅ التصحيح هنا
}

public function waitingLists()
{
    return $this->hasMany(WaitingList::class);
}
}
