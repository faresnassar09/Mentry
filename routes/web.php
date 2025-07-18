<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




Route::post('/start-timer', function (Illuminate\Http\Request $request) {
    $minutes = (int) $request->input('minutes');
    $endTime = now()->addMinutes($minutes);
    session(['timer_end' => $endTime]);

    return redirect()->back();
})->name('start.timer');



Route::get('/', function () {
    return view('welcome');
});

