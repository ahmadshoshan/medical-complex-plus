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
        Schema::table('items', function (Blueprint $table) {
            $table->integer('stock_quantity')->default(0)->after('name'); // الكمية في المخزون
            $table->decimal('cost_price', 15, 2)->default(0)->after('stock_quantity'); // سعر التكلفة
            $table->decimal('selling_price', 15, 2)->default(0)->after('cost_price'); // سعر البيع
            $table->integer('min_stock')->default(10)->after('selling_price'); // الحد الأدنى للمخزون
            $table->string('barcode')->nullable()->unique()->after('min_stock'); // الباركود
            $table->string('unit')->default('piece')->after('barcode'); // الوحدة (قطعة/علبة/...)
            $table->string('category')->nullable()->after('unit'); // الفئة
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};