<?php

namespace App\Filament\Widgets;

use App\Models\WaitingList;
use App\Models\Doctor;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DoctorCasesChart extends ChartWidget
{
        protected ?string $pollingInterval = null;

    protected static bool $isDiscovered = false;
    public static function shouldRegisterNavigation(): bool
    {
        return false; // مش هيظهر في النافيجيشن
    }
    protected ?string $heading = 'عدد الحالات لكل طبيب (الشهر الحالي)';

    protected function getData(): array
    {
        $now = Carbon::now();

        // تجميع الحالات حسب الدكتور للشهر الحالي
        $cases = WaitingList::select('doctor_id', DB::raw('COUNT(*) as total'))
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->groupBy('doctor_id')
            ->with('doctor') // عشان نجيب اسم الدكتور
            ->get();

        // أسماء الأطباء
        $labels = $cases->map(fn($item) => $item->doctor?->name ?? 'غير معروف')->toArray();

        // عدد الحالات لكل طبيب
        $data = $cases->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'عدد الحالات',
                    'data' => $data,
                    'backgroundColor' => '#3b82f6', // أزرق (تقدر تغير اللون)
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // ممكن تخليها 'pie' أو 'doughnut' حسب ما تحب
    }
}
