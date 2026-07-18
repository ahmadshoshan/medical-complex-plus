<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalPurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'item_id',
        'quantity',
        'unit_price',
        'total',
    ];

    public function MedicalPurchase()
    {
        return $this->belongsTo(MedicalPurchase::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
