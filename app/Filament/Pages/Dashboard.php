<?php

namespace App\Filament\Pages;

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


// public function getFooter(): ?\Illuminate\Contracts\View\View
// {
//     return view('components.voice-announcement');
// }

}
