<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'tax_number',
        'balance',
        'notes',
    ];

    public function purchaseInvoices()
    {
        return $this->hasMany(PurchaseInvoice::class);
    }


    public function MedicalPurchases()
    {
        return $this->hasMany(MedicalPurchase::class);
    }
}
