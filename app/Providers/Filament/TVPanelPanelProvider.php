<?php

namespace App\Providers\Filament;

use App\Filament\Pages\TV;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Livewire\Sidebar;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TVPanelPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
           ->id('tv') // معرف اللوحة
            ->path('tv') // الرابط هيبقى /tv
            ->pages([
                TV::class, // صفحة شاشة العرض
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
              ->brandName('ادارة المجمع الطبي') // اسم العلامة

            ->sidebarFullyCollapsibleOnDesktop()

            ->sidebarLivewireComponent(Sidebar::class)


            ->discoverResources(in: app_path('Filament/TVPanel/Resources'), for: 'App\Filament\TVPanel\Resources')
            ->discoverPages(in: app_path('Filament/TVPanel/Pages'), for: 'App\Filament\TVPanel\Pages')

            ->discoverWidgets(in: app_path('Filament/TVPanel/Widgets'), for: 'App\Filament\TVPanel\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                // AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            // ->authMiddleware([
            //     Authenticate::class,
            // ])
            ;
    }
}
