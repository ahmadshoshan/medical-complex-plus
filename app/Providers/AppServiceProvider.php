<?php

namespace App\Providers;

use App\Filament\Http\Responses\LoginResponse;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\ServiceProvider;
use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
// use App\Http\Responses\LoginResponse as CustomLoginResponse;
use App\Filament\Http\Responses\LoginResponse as CustomLoginResponse;
use App\Http\Responses\CustomLoginResponse as ResponsesCustomLoginResponse;
use Filament\Auth\Http\Responses\LoginResponse as ResponsesLoginResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

  public function register(): void
{
    $this->app->singleton(ResponsesLoginResponse::class, ResponsesCustomLoginResponse::class);
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar','en']); // also accepts a closure
        });


         \App\Models\Patient::observe(\App\Observers\StatObserver::class);
        \App\Models\WaitingList::observe(\App\Observers\WaitingListObserver::class);
        \App\Models\AppointmentDoctors::observe(\App\Observers\DoctorAppointmentsObserver::class);
        \App\Models\Gallery::observe(\App\Observers\GalleryObserver::class);
        \App\Models\Donation::observe(\App\Observers\DonationObserver::class);
        \App\Models\Doctor::observe(\App\Observers\DoctorObserver::class);

    }

}
