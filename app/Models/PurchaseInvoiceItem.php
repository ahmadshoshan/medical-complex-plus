<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItem extends Model
{
    protected $fillable = [
        'purchase_invoice_id',
        'item_id',
        'item_name',
        'quantity',
        'cost_price',
        'selling_price',
        'total',
    ];

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoiceItem::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}