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
        Schema::create('appointment_doctors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->json('days');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
