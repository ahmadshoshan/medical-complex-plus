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
     // database/migrations/xxxx_xx_xx_create_invoices_table.php
Schema::create('invoices', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number')->unique();   // رقم الفاتورة
    $table->date('invoice_date');                 // تاريخ الفاتورة
    $table->string('type');                       // نوعها (بيع / شراء)
    $table->decimal('total', 10, 2);              // الإجمالي
    $table->string('customer')->nullable();       // العميل (لو بيع)
    $table->string('supplier')->nullable();       // المورد (لو شراء)
    $table->text('notes')->nullable();            // ملاحظات
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
