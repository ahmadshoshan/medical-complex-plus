<?php

use App\Filament\Pages\TV;
use App\Http\Controllers\PublicTvController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/tv', function () {
//     return view('public-tv-screen');
// });

// Route::get('/tv', [PublicTvController::class, 'show'])->name('tv.screen');





// Route::get('/admin/tv', function () {
//     return redirect()->route('filament.admin.pages.t-v');
// })->withoutMiddleware([
//     \Filament\Http\Middleware\Authenticate::class,
// ]);





