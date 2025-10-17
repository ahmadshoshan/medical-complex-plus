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

use App\Models\WaitingList;


Route::get('/waiting-list/{record}/print', function (WaitingList $record) {
    return view('waiting-list.print', compact('record'));
})->name('waiting-list.print');




// web.php في Laravel
Route::get('/tts', function (Illuminate\Http\Request $r) {
    $text = urlencode($r->query('text', 'مرحبا'));
    $url = "https://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q={$text}&tl=ar";
    $ctx = stream_context_create(['http' => ['header' => "User-Agent: stagefright/1.2\r\n"]]);
    return response()->stream(function () use ($url, $ctx) {
        echo file_get_contents($url, false, $ctx);
    }, 200, ['Content-Type' => 'audio/mpeg']);
});




