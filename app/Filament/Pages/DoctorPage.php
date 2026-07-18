<?php

namespace App\Filament\Pages;


use App\Filament\Widgets\DoctorListControlWidget;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class DoctorPage extends Page
{


  public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        // لو مفيش مستخدم مسجل دخول
        if (! $user) {
            return false;
        }
// dd($user->role);
        // يظهر بس لو المستخدم Admin
         if ($user->role === 'admin' || $user->role === 'doctors_page') {
            return true;
        } else {
            return false;
        }
        //
    }
    // public static function canAccess(): bool
    // {


    //     $user = Auth::user();s

    //     // لو مفيش مستخدم مسجل دخول
    //     if (! $user) {
    //         return false;
    //     }

    //     // يظهر بس لو المستخدم Admin
    //      if ($user->role === 'admin' || $user->role === 'doctors_page') {
    //         return true;
    //     } else {
    //         return false;
    //     }
    //     //
    // }
    // 🚫 إلغاء ظهور التوب بار في الصفحة دي بس
    // protected static bool $hasTopbar = false;
    // protected static ?string $navigationBadgeTooltip = null;
    protected static ?string $navigationLabel = 'لوحة تحكم الطبيب';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ViewfinderCircle;
    protected static ?string $title = 'لوحة تحكم الطبيب';




    protected static ?int $navigationSort = 1;
    protected static string|\UnitEnum|null $navigationGroup = 'ادارة الاطباء';






    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Action::make('edit'),
    //         Action::make('delete')
    //             ->requiresConfirmation(),
    //     ];
    // }


    //  public $defaultAction = 'onboarding';

    //     public function onboardingAction(): Action
    //     {
    //         $doctor = Auth::user()?->doctor;

    //         return Action::make('onboarding')
    //             ->modalHeading('مرحباً دكتور ' . ($doctor?->name ?? 'غير محدد'))
    //             ->modalDescription('هل تريد تفعيل استقبال الحالات الآن؟')
    //             ->label('تفعيل استقبال الحالات')
    //             ->color('success')
    //             ->visible(fn (): bool => !$doctor?->is_active) // يظهر فقط لو مش مفعل
    //             ->action(function () use ($doctor) {
    //                 if ($doctor) {
    //                     $doctor->update(['is_active' => true]);
    //                 }
    //             })
    //             ->modalSubmitActionLabel('نعم، فعل الاستقبال')
    //             ->modalCancelActionLabel('إلغاء');
    //     }

    // 🟢 زر دائم للتبديل (يظهر في أعلى الصفحة)
    protected function getHeaderActions(): array
    {
        $doctor = Auth::user()?->doctor;

        return [
            // ✅ حالة الاستقبال
            Action::make('toggleActive')
                ->label(fn() => $doctor?->is_active ? 'العيادة مفعلة' : 'العيادة متوقفة')
                ->icon(fn() => $doctor?->is_active ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->color(fn() => $doctor?->is_active ? 'success' : 'danger')
                ->action(function () use ($doctor) {
                    if ($doctor) {
                        $doctor->update(['is_active' => ! $doctor->is_active]);
                    }
                }),

            // ✅ حالة موظف الاستقبال
            Action::make('toggleReceptionist')
                ->label(fn() => $doctor?->allow_receptionist_call
                    ? 'موظف الاستقبال مسموح له باستدعاء الحالات'
                    : 'موظف الاستقبال غير مسموح له')
                ->icon(fn() => $doctor?->allow_receptionist_call
                    ? 'heroicon-o-check-circle'
                    : 'heroicon-o-x-circle')
                ->color(fn() => $doctor?->allow_receptionist_call ? 'success' : 'danger')
                ->action(function () use ($doctor) {
                    if ($doctor) {
                        $doctor->update([
                            'allow_receptionist_call' => ! $doctor->allow_receptionist_call
                        ]);
                    }
                }),

        ];
    }










    protected function getHeaderWidgets(): array
    {
        return [


            // DoctorActiveControlWidget::class,
            DoctorListControlWidget::class,


        ];
    }

    public function getFooterWidgets(): array
    {
        return [];
    }
}
