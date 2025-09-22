<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BusyDaysChart;
use App\Filament\Widgets\DoctorCasesChart;
use App\Filament\Widgets\PatientStatusChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TopDoctorsWeeklyChart;
use Filament\Pages\Dashboard as BaseDashboard;
class Dashboard extends BaseDashboard
{


//   protected string $view = 'filament.pages.custom-dashboard';

    // protected static ?string $title = 'home';

    // اختياري: إزالة من القائمة
    public static function shouldRegisterNavigation(): bool
    {
        return false; // لا تظهر في القائمة الجانبية
    }


 protected function getHeaderWidgets(): array
    {
        return [



            StatsOverview::class,
            BusyDaysChart::class,
            DoctorCasesChart::class,
            PatientStatusChart::class,
            TopDoctorsWeeklyChart::class,


        ];
    }



// public function getFooter(): ?\Illuminate\Contracts\View\View
// {
//     return view('components.voice-announcement');
// }

}
