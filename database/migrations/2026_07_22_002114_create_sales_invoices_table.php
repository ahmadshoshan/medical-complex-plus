<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // رقم الفاتورة
            $table->foreignId('patient_id')->nullable()->constrained(); // المريض
            $table->foreignId('waiting_list_id')->nullable()->constrained(); // قائمة الانتظار
            $table->date('invoice_date'); // تاريخ الفاتورة
            $table->decimal('subtotal', 15, 2)->default(0); // المجموع الفرعي
            $table->decimal('discount', 15, 2)->default(0); // الخصم
            $table->decimal('tax', 15, 2)->default(0); // الضريبة
            $table->decimal('total', 15, 2)->default(0); // الإجمالي
            $table->decimal('paid_amount', 15, 2)->default(0); // المدفوع
            $table->decimal('remaining_amount', 15, 2)->default(0); // المتبقي
            $table->enum('status', ['pending', 'partial', 'paid', 'canceled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_invoices');
    }
};