<?php
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\Reading\BookController as ReadingBookController;
use App\Http\Controllers\Api\Study\BookController;
use App\Http\Controllers\Api\Study\MaterialController;
use App\Http\Controllers\Api\Study\NoteController;
use App\Http\Controllers\Api\Study\ScheduleController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Writing\BookController as WritingBookController;
use App\Http\Controllers\Api\Writing\NoteController as WritingNoteController;
use App\Http\Controllers\Api\Writing\SnippetController;
use Illuminate\Support\Facades\Route;



// Authentcation

Route::controller(AuthenticationController::class)
->prefix('v1/user/')
->group(function(){

Route::Post('login','login');

Route::Post('register','register');

Route::post('logout','logout')
->middleware('auth:sanctum');

});
 
                // study

Route::prefix('v1/user/study')
->middleware('auth:sanctum')
->group(function(){


    //Study books
Route::get('books/download/{book}',[BookController::class,'download']);
Route::apiResource('books',BookController::class)
->except('update');


//Study Materials

Route::get('materials/download/{material}',[MaterialController::class,'download']);
Route::apiResource('materials',MaterialController::class)
->except('update');

// Study Notes

Route::apiResource('notes',NoteController::class);

//Study Schedule

Route::apiResource('schedules',ScheduleController::class)
->only(['index','store']);

});

    //reading

Route::prefix('v1/user/reading/')
->middleware('auth:sanctum')
->group(function(){

    Route::get('books/download/{id}',[ReadingBookController::class,'download']);
    Route::apiResource('books',ReadingBookController::class)
    ->only(['index','show']);

}); 


Route::prefix('v1/user/writing/') 
->middleware('auth:sanctum')
->group(function(){

 // writing Books

Route::get('books/download/{book}',[WritingBookController::class,'download']); 
Route::apiResource('books',WritingBookController::class);

//Writing notes

Route::apiResource('notes',WritingNoteController::class);

// Writing Snippets

Route::apiResource('snippets',SnippetController::class);

});
 
//profile
Route::controller(ProfileController::class)
->prefix('v1/user/profile/') 
->middleware('auth:sanctum')
->group(function(){

Route::get('/','index');
Route::patch('update/{user}','update');
Route::delete('delete/{user}','destroy');

});

 //dashboard

 Route::controller(UserController::class)
 ->prefix('v1/user/') 
 ->middleware('auth:sanctum')
 ->group(function(){

Route::get('dashboard','dashboard');


 });