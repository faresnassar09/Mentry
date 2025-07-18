<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Study\BookController;
use App\Http\Controllers\Study\MaterialController;
use App\Http\Controllers\Study\ScheduleController;
use App\Http\Controllers\Study\NoteController;

 

Route::controller(BookController::class)
->prefix('users/study/books/')
->name('users.study.books.')
-> middleware('auth')
->group(function(){

    Route::get('index','index')->name('index');
    Route::get('create','create')->name('create');
    Route::post('create','store')->name('insert');
    Route::get('view/{book}','view')->name('view');
    Route::get('download/{book}','download')->name('download');
    Route::delete('delete/{book}','delete')->name('delete');

});    

Route::controller(MaterialController::class)
->prefix('users/study/materials/')
->name('users.study.materials.')
-> middleware('auth')
->group(function(){

    Route::get('index','index')->name('index');
    Route::get('create','create')->name('create');
    Route::post('create','store')->name('insert');
    Route::get('view/{material}','view')->name('view');
    Route::get('download/{material}','download')->name('download');
    Route::delete('delete/{material}','delete')->name('delete');
    
});  


Route::controller(NoteController::class)
->prefix('users/study/notes/')
->name('users.study.notes.')
-> middleware('auth')
->group(function(){

    Route::get('index','index')->name('index');
    Route::get('create','create')->name('create');
    Route::post('create','store')->name('insert');  
    Route::get('edit/{note}','edit')->name('edit');
    Route::post('update/{note}','update')->name('update');
    Route::delete('delete/{note}','delete')->name('delete');
    
});  


Route::controller(ScheduleController::class)
->prefix('users/study/schedules/')
->name('users.study.schedules.')
-> middleware('auth')
->group(function(){

    Route::get('index','index')->name('index');
    Route::get('create','create')->name('create');
    
});  