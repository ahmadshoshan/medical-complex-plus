<?php

use App\Models\SalaryPayment;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:run')->daily()->at('03:00'); // كل يوم الساعة 3 صباحاً
Schedule::command('backup:clean')->daily()->at('04:00'); // تنظيف النسخ القديمة

Schedule::call(function () {
    $pendingCount = SalaryPayment::where('status', 'pending')
        ->where('month', now()->month)
        ->where('year', now()->year)
        ->count();

    if ($pendingCount === 0) {
        return;
    }

    Notification::make()
        ->title('تذكير بدفع المرتبات')
        ->body("يوجد {$pendingCount} مرتب معلق للدفع لهذا الشهر")
        ->warning()
        ->sendToDatabase(User::all(), true);
})->monthlyOn(1, '08:00');