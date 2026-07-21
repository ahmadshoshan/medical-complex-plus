<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:run')->daily()->at('03:00'); // كل يوم الساعة 3 صباحاً
Schedule::command('backup:clean')->daily()->at('04:00'); // تنظيف النسخ القديمة