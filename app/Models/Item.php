<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // 'category_id',
        'unit',
        'barcode',
        'purchase_price',
        'sale_price',
        'quantity',
        'min_quantity',
        'expiry_date',
    ];

    /**
     * 🔗 العلاقات
     */

    // الصنف ينتمي لتصنيف
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }

    // الصنف مرتبط بمشتريات
    public function MedicalPurchaseItem()
    {
        return $this->hasMany(MedicalPurchaseItem::class);
    }

    // الصنف مرتبط بمبيعات
    public function saleItems()
    {
        return $this->hasMany(MedicalSaleItem::class);
    }
}
