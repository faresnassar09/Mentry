<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


// Route::get('test',[\App\Http\Controllers\Algoritms::class,'get']);


Route::get('lang/change/{lang}',function (string $lang) {
   
if (!in_array($lang,['ar','en'])) {

    abort(404);

}

// App::setLocale($lang);

return response('Lang set')->cookie(Cookie::forever('lang', $lang));

// Log::channel('userapi')->info('lk',[$lang]);


});

Route::post('/start-timer', function (Illuminate\Http\Request $request) {
    $minutes = (int) $request->input('minutes');
    $endTime = now()->addMinutes($minutes);
    session(['timer_end' => $endTime]);

    return redirect()->back();
})->name('start.timer');



Route::get('/', function () {
    return view('welcome');
})->middleware('guest');
