<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'payment_status',
    ];

    public function items()
    {
        return $this->hasMany(MedicalSaleItem::class);
    }
}
