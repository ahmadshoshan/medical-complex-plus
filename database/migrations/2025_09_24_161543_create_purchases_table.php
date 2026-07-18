<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     Schema::create('purchases', function (Blueprint $table) {
    $table->id();
    $table->string('item');          // اسم الصنف
    $table->integer('quantity');     // الكمية
    $table->decimal('price', 10, 2); // السعر
    $table->date('purchase_date');   // تاريخ الشراء
    $table->string('supplier')->nullable(); // المورد
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
