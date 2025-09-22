<?php

namespace App\Filament\Widgets;

use App\Models\WaitingList;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TopDoctorsWeeklyChart extends ChartWidget
{
        protected ?string $pollingInterval = null;

    protected static bool $isDiscovered = false;
    public static function shouldRegisterNavigation(): bool
    {
        return false; // مش هيظهر في النافيجيشن
    }
    protected ?string $heading = 'أكثر الأطباء زيارات (آخر أسبوع)';

    protected function getData(): array
    {
        $now = Carbon::now();

        // المدة: من 7 أيام فاتت لحد دلوقتي
        $startDate = $now->copy()->subDays(7);

        $cases = WaitingList::select('doctor_id', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $now])
            ->groupBy('doctor_id')
            ->with('doctor')
            ->orderByDesc('total')
            ->limit(10) // نعرض أفضل 10 أطباء فقط
            ->get();

        // أسماء الأطباء
        $labels = $cases->map(fn($item) => $item->doctor?->name ?? 'غير معروف')->toArray();

        // عدد الحالات لكل طبيب
        $data = $cases->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'عدد الزيارات',
                    'data' => $data,
                    'backgroundColor' => [
                        '#3b82f6', '#ef4444', '#22c55e', '#f59e0b', '#6366f1',
                        '#ec4899', '#14b8a6', '#8b5cf6', '#f97316', '#84cc16'
                    ], // ألوان مميزة لكل دكتور
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // أو 'bar' لو تحب
    }
}


//    bar
//    bubble
//    doughnut
//    line
//    pie
//    polarArea
//    radar
