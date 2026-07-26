<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained(); // الصنف
            $table->string('item_name'); // اسم الصنف (نسخة احتياطية)
            $table->integer('quantity'); // الكمية
            $table->decimal('unit_price', 15, 2); // سعر الوحدة
            $table->decimal('discount', 15, 2)->default(0); // الخصم
            $table->decimal('total', 15, 2); // الإجمالي
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_items');
    }
};