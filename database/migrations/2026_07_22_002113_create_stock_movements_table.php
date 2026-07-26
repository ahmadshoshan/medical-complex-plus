<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['in', 'out', 'adjustment']); // نوع الحركة (وارد/صادر/تعديل)
            $table->integer('quantity'); // الكمية
            $table->decimal('cost_price', 15, 2)->nullable(); // سعر التكلفة
            $table->string('reference_type')->nullable(); // نوع المرجع (Sale/Purchase/Adjustment)
            $table->unsignedBigInteger('reference_id')->nullable(); // معرف المرجع
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained(); // المستخدم
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};