<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalSaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'item_id',
        'quantity',
        'unit_price',
        'total',
    ];

    public function MedicalSale()
    {
        return $this->belongsTo(MedicalSale::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
