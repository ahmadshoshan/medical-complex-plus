<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DoctorAppointmentsWidget;
use App\Filament\Widgets\GallerySlider;
use App\Filament\Widgets\GallerySlider2;
use App\Filament\Widgets\ImagesSliderWidget;
use App\Filament\Widgets\StatsDoctor;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TWidget;
use App\Filament\Widgets\WaitingListWidget;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class TV extends Page
{
    // 🚫 إلغاء ظهور التوب بار في الصفحة دي بس
    protected static bool $hasTopbar = false;
    protected static ?string $navigationBadgeTooltip = null;
    protected static ?string $navigationLabel = 'شاشة العرض';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTv;
    protected static ?string $title = '';

    // 👇 هنا بنديها slug مخصص
    // وبالتالي Laravel  بيولّد Route باسم
    // filament.admin.pages.t-v.
    //     protected static ?string $slug = 't-v';
    // protected static ?string $routeName = 'filament.admin.pages.t-v';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        // لو مفيش مستخدم مسجل دخول
        if (! $user) {
            return false;
        }
        if ($user->role === 'admin' || $user->role === 't-v') {
            return true;
        } else {
            return false;
        }
        // يظهر بس لو المستخدم Admin
        // return $user->role === 'admin'||'t_v';
    }


    protected static ?int $navigationSort = 1;
    protected static string|\UnitEnum|null $navigationGroup = 'ادارة شاشة العرض';
    // تسمية نموذج المورد

    public static function canAccess(): bool
    {
        return true; // السماح بالوصول بدون Authentication
    }

    public function getFooter(): ?\Illuminate\Contracts\View\View
    {
        return view('components.voice-announcement');
    }




    // protected int | string | array $columnSpan = 6; // نصف الشاشة


    protected function getHeaderWidgets(): array
    {
        return [

            StatsDoctor::class,
            // DoctorAppointmentsWidget::class
            // StatsOverview::class,

        ];
    }

    public function getFooterWidgets(): array
    {
        return [

            WaitingListWidget::class,
            //   ImagesSliderWidget::class, // ✅ إضافة السلايدر::class,
            // GallerySlider::class, // ✅ إضافة السلايدر::class,
            GallerySlider2::class, // ✅ إضافة السلايدر::class,


        ];
    }
}
