<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model //المصروفات
{
      protected $fillable = [
        'amount',
         'category',
         'description',
         'm_id',
          'date'
        ];
}
