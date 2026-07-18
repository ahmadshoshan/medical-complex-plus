<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custody extends Model
{
       protected $fillable = [

        'item',
        'quantity',
        'employee',
        'handover_date',

    ];
}
