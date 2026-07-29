<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Schema::table('items', function (Blueprint $table) {
        //     $table->dropColumn([
        //         'stock_quantity', 
        //         'cost_price',
        //          'selling_price', 
        //          'min_stock', 
        //          'unit', 
        //          'category',
        //          ]);
        // });
    }
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('stock_quantity')->default(0)->after('name');
            $table->decimal('cost_price', 15, 2)->default(0)->after('stock_quantity');
            $table->decimal('selling_price', 15, 2)->default(0)->after('cost_price');
            $table->integer('min_stock')->default(10)->after('selling_price');
            $table->string('unit')->default('piece')->after('name');
            $table->string('category')->nullable()->after('unit');
        });
    }
};
