<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
class CustomLoginResponse implements LoginResponseContract
{
   public function toResponse($request)
    {
        $user = Auth::user();

        if ($user && $user->home_page) {
            // ✅ لو home_page بيساوي اسم Route
            if (Route::has($user->home_page)) {
                return redirect()->route($user->home_page);
            }

            // ✅ لو URL عادي
            return redirect()->to($user->home_page);
        }

        // ✅ الافتراضي: يروح على لوحة Filament
        return redirect()->intended(filament()->getUrl());
    }
}
