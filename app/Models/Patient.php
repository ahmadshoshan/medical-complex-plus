<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable=[
        'name',
        'Patien',
        'phone',
        'national_id',
        'date_of_birth',
        'gender',
        'address',
        'medical_history',


    ];
}
