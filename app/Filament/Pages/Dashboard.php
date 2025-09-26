<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BusyDaysChart;
use App\Filament\Widgets\DoctorCasesChart;
use App\Filament\Widgets\PatientStatusChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TopDoctorsWeeklyChart;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{


    //   protected string $view = 'filament.pages.custom-dashboard';

    protected static ?string $title = '';
    protected static ?string $navigationLabel = 'لوحة التحكم';

    // اختياري: إزالة من القائمة
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        // لو مفيش مستخدم مسجل دخول
        if (! $user) {
            return false;
        }

        // يظهر بس لو المستخدم Admin
         if ($user->role === 'admin' || $user->role === 'dashboard') {
            return true;
        } else {
            return false;
        }
        //
    }
    public static function canAccess(): bool
    {


        $user = Auth::user();

        // لو مفيش مستخدم مسجل دخول
        if (! $user) {
            return false;
        }

        // يظهر بس لو المستخدم Admin
         if ($user->role === 'admin' || $user->role === 'dashboard') {
            return true;
        } else {
            return false;
        }
        //
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
