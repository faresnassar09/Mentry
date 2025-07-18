<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\writing\BookController;
use FontLib\Table\Type\name;

Route::controller(BookController::class)
->middleware('auth')
->prefix('users/writing/books/')
->name('users.writing.books.')
->group(function(){


Route::get('index','index')->name('index');
Route::get('create','create')->name('create');
Route::post('create','store')->name('store');
Route::get('edit/{book}','edit')->name('edit');
Route::patch('update/{book}','update')->name('update');
Route::get('download/{book}','download')->name('download');
Route::delete('delete/{book}','delete')->name('delete');


});         

Route::prefix('users/writing/')->name('users.writing.')->group(function(){


    
     Route::view('notes/index','users.writing.notes.index')->name('notes.index');

     Route::view('snippets/index','users.writing.snippets.index')->name('snippets.index');

});

