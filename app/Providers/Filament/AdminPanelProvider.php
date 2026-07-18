<?php

namespace App\Providers\Filament;

use App\Filament\Pages\CustomLogin;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Livewire\Sidebar;

use Filament\Panel;
use Filament\PanelProvider;

use Filament\Support\Colors\Color;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(CustomLogin::class) // ✅ استخدم صفحة Login مخصصة


            ->colors([
                'primary' => Color::Amber,
            ])



            ////////////////////////////////
            ->brandName('ادارة المجمع الطبي') // اسم العلامة

            // -> sidebarCollapsibleOnDesktop()
            ->sidebarFullyCollapsibleOnDesktop()
            // ->topNavigation()
            // ->topbar(false)
            // ->navigation(false)
            ->sidebarLivewireComponent(Sidebar::class)


            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                // Dashboard::class,
                 \App\Filament\Pages\TV::class, // 👈 صفحة t-v
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,

            ])
            ->databaseNotifications();
    }
}
