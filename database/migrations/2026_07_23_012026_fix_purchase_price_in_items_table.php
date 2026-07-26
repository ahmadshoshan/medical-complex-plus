<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // جعل الحقل يقبل القيمة الافتراضية 0
            $table->decimal('purchase_price', 15, 2)->default(0)->change();
            $table->decimal('sale_price', 15, 2)->default(0)->change();
              $table->string('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('purchase_price', 15, 2)->nullable(false)->change();
            $table->decimal('sale_price', 15, 2)->nullable(false)->change();
        });
    }
};