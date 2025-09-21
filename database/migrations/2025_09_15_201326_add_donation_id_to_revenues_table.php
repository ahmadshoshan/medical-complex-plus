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
    Schema::table('revenues', function (Blueprint $table) {
        $table->foreignId('donation_id')->nullable()->constrained('donations')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('revenues', function (Blueprint $table) {
        $table->dropForeign(['donation_id']);
        $table->dropColumn('donation_id');
    });
}

};
