<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'specialty',
        'phone',

        'bio',
        'is_active','allow_receptionist_call'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * علاقة "ينتمي إلى" مع المستخدم
     * كل طبيب هو مستخدم واحد
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function appointment_doctors(): HasMany
    {
        return $this->hasMany(AppointmentDoctors::class);
    }
    public function room()
    {
        return $this->hasOne(Room::class, 'doctor_id');
    }
     public function waitingLists(): HasMany
    {
        return $this->hasMany(WaitingList::class, 'doctor_id');
    }
}
