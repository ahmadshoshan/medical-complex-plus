<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('suppliers')) {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->string('tax_number')->nullable();
                $table->decimal('balance', 15, 2)->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        } else {
            // الجدول موجود، أضف الأعمدة الناقصة فقط
            Schema::table('suppliers', function (Blueprint $table) {
                if (!Schema::hasColumn('suppliers', 'tax_number')) {
                    $table->string('tax_number')->nullable()->after('address');
                }
                if (!Schema::hasColumn('suppliers', 'balance')) {
                    $table->decimal('balance', 15, 2)->default(0)->after('tax_number');
                }
                if (!Schema::hasColumn('suppliers', 'notes')) {
                    $table->text('notes')->nullable()->after('balance');
                }
                // تأكد أن address من نوع text وليس string
                if (Schema::hasColumn('suppliers', 'address')) {
                    $table->text('address')->change();
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};