<?php

namespace App\Filament\Widgets;

use App\Models\WaitingList;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BusyDaysChart extends ChartWidget
{
        protected ?string $pollingInterval = null;

    protected static bool $isDiscovered = false;
    public static function shouldRegisterNavigation(): bool
    {
        return false; // مش هيظهر في النافيجيشن
    }
    protected ?string $heading = 'الأيام المزدحمة (آخر أسبوع)';

    protected function getData(): array
    {
        $now = Carbon::now();
        $startDate = $now->copy()->subDays(30);

        // نجمع الحالات حسب اليوم
        $cases = WaitingList::select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$startDate, $now])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // الأيام + عدد الحالات
        $labels = $cases->map(fn($item) => Carbon::parse($item->day)->translatedFormat('l d M'))->toArray();
        // مثال: الاثنين 16 سبتمبر

        $data = $cases->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'عدد الحالات',
                    'data' => $data,
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // ممكن تخليها 'line' لو عايز خط
    }
}
