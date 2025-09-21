<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //الايرادات
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->string('type'); // كشف، إجراء، تبرع
            $table->text('description')->nullable();
            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
            $table->foreignId('waiting_lists_id')->nullable()->constrained('waiting_lists')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
};
