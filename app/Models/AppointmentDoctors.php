<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentDoctors extends Model
{
    protected $fillable = [
        'doctor_id',
        'start_time',
        'end_time',
        'days',
        'notes',
    ];





    /**
     * ✨ الخطوة الأهم: تحويل حقل 'days' تلقائياً إلى مصفوفة والعكس
     *
     * @var array
     */
    protected $casts = [
        'days' => 'array',
    ];
    public function getDaysListAttribute()
{
    return implode(' - ', $this->days ?? []);
}

public function getStartTime12Attribute()
{
    return $this->attributes['start_time'] ? Carbon::parse($this->attributes['start_time'])->format('i h A') : null;
}
public function getEndTime12Attribute()
{
    return $this->attributes['end_time'] ? Carbon::parse($this->attributes['start_time'])->format('i h A') : null;
}
    // public function getDaysAttribute($value)
    // {
    //     // إذا كانت قيمة نصية، حوّلها إلى مصفوفة
    //     if (is_string($value)) {
    //         return [$value];
    //     }

    //     return $value; // إذا كانت مصفوفة، ارجعها كما هي
    // }
    // ✅ العلاقة الصحيحة: كل سجل مواعيد يخص طبيب واحد
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
