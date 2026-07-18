<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',   // رقم الفاتورة
        'invoice_date',                 // تاريخ الفاتورة
        'type',                      // نوعها (بيع / شراء)
        'total',            // الإجمالي
        'customer',     // العميل (لو بيع)
        'supplier',  // المورد (لو شراء)
        'notes',
    ];
}
