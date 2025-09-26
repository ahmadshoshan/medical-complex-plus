<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [

        'item',
        'quantity',
        'price',
        'purchase_date',
        'supplier',

    ];
}
