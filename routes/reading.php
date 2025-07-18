<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reading\BookController;



Route::controller(BookController::class)
->middleware('auth')
->prefix('reading/books/')
->name('reading.books.')
->group(function(){

Route::get('index','index')->name('index');
Route::get('read/{book}','read')->name('read');
Route::get('download/{book}','download')->name('download');


});

