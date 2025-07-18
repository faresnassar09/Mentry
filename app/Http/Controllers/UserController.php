<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reading\Book;
class UserController extends Controller
{

public function dashboard(){
    $user = Auth::user();
    
    $data = [
        
          'studyBooksCount' => $user->studyBooks->count(),
          'userBooks' => $user->userBooks->count(),
          'studySummers' => $user->studyMaterials->where('type',2)->count(),
          'studyMiniBooks' => $user->studyMaterials->where('type',1)->count(),
          'userNotes' => $user->userNotes->count(),
          'userSnippets' => $user->userSnippets->count(),
          'readingBooks' => Book::count(),
          

          
    
    ];
    
return view('users.dashboard',compact('data'));
}

}
