<?php

namespace App\Filament\Widgets;

use App\Models\WaitingList;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientStatusChart extends ChartWidget
{
        protected ?string $pollingInterval = null;

    protected static bool $isDiscovered = false;
    public static function shouldRegisterNavigation(): bool
    {
        return false; // مش هيظهر في النافيجيشن
    }
    protected ?string $heading = 'توزيع حالات المرضى حسب الحالة (الشهر الحالي)';

    protected function getData(): array
    {
        $now = Carbon::now();

        $cases = WaitingList::select('status', DB::raw('COUNT(*) as total'))
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->groupBy('status')
            ->get();

        $labels = $cases->pluck('status')->map(function ($status) {
            return match ($status) {
                'waiting'   => 'في الانتظار',
                'in_progress' => 'جاري الكشف',
                'completed'      => 'مكتمل ',
                'canceled' => 'ملغي',
                default     => ucfirst($status),
            };
        })->toArray();

        $data = $cases->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'عدد الحالات',
                    'data' => $data,
                    'backgroundColor' => [
                        '#3b82f6', // في الانتظار
                        '#22c55e', // تم الكشف
                        '#ef4444', // ملغي
                        '#f59e0b', // أخرى
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // أو
    }
}
