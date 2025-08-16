<?php

use \App\Http\Controllers\Algoritms;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('language/switch/{lang}',function (string $lang) {
   
if (!in_array($lang,['ar','en'])) {

    abort(404);

}

return back()->cookie(Cookie::forever('lang', $lang));

})->name('language.switch');

Route::post('/start-timer', function (Illuminate\Http\Request $request) {
    $minutes = (int) $request->input('minutes');
    $endTime = now()->addMinutes($minutes);
    session(['timer_end' => $endTime]);

    return redirect()->back();
})->name('start.timer');



Route::get('/', function () {
    return view('index');
})->middleware('guest');
