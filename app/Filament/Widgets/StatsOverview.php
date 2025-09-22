<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Revenue;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class StatsOverview extends BaseWidget

{
    public function getColumns(): int | array
    {
        return 3;
    }
    // protected static bool $isDiscovered = false;

    protected ?string $pollingInterval = null;


    protected static bool $isDiscovered = false;
    public static function shouldRegisterNavigation(): bool
    {
        return false; // مش هيظهر في النافيجيشن
    }

    protected int $revenue;
    protected int $expense;
    protected int $revenueMonth;
    protected int $expenseMonth;
    protected string $monthName;
    protected array $revenueChart;
    protected array $expenseChart;

    public function __construct()
    {
        // هنا هنجيب مجموع العمود amount
        $this->revenue = Revenue::sum('amount');
        $this->expense = Expense::sum('amount');
        $now = Carbon::now();
        $this->monthName = $now->translatedFormat('F Y'); // اسم الشهر الحالي (مثلاً: سبتمبر 2025)

        // اجمالي الايرادات للشهر الحالي
        $this->revenueMonth = Revenue::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('amount');

        // اجمالي المصروفات للشهر الحالي
        $this->expenseMonth = Expense::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('amount');
        // رسم بياني يومي للإيرادات
        $this->revenueChart = Revenue::selectRaw('DAY(created_at) as day, SUM(amount) as total')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day')
            ->toArray();

        // رسم بياني يومي للمصروفات
        $this->expenseChart = Expense::selectRaw('DAY(created_at) as day, SUM(amount) as total')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day')
            ->toArray();
    }

    protected function getStats(): array
    {
        return [
            Stat::make('اجمالي الايرادات', number_format($this->revenue))
                ->descriptionIcon('heroicon-o-currency-dollar', 'before')
                ->color('success')
                ->dehydrated()
                ->chart([$this->revenue, 3, 4, 5, 3, 5, 3]),

            Stat::make('اجمالي المصروفات', number_format($this->expense))
                ->color('danger')
                ->dehydrated()
                ->chart([$this->expense, 3, 4, 5, 3, 5, 3]),




            Stat::make('الصافي', number_format($this->revenue - $this->expense))

                ->color($this->revenue - $this->expense >= 0 ? 'success' : 'danger')
                ->chart([$this->expense, 3, 4, 5, 3, 5, 3]),




            Stat::make("اجمالي ايرادات {$this->monthName}", number_format($this->revenueMonth))
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->chart(array_values($this->revenueChart)),

            Stat::make("اجمالي مصروفات {$this->monthName}", number_format($this->expenseMonth))
                ->icon('heroicon-o-credit-card')
                ->color('danger')
                ->chart(array_values($this->expenseChart)),

            Stat::make("صافي {$this->monthName}", number_format($this->revenueMonth - $this->expenseMonth))
                ->icon('heroicon-o-calculator')
                ->color($this->revenue - $this->expense >= 0 ? 'success' : 'danger')
                ->chart(array_values($this->revenueChart) ?: [0]),

        ];
    }
}
