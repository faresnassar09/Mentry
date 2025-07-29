<?php

namespace App\Service\Api\Writing;

use Illuminate\Support\Facades\Auth;

class NoteService{


public function getUserNotes(){

    return Auth::user()->userNotes()->with('writingBook')->get();


}

public function  createUserNote($bookId,$content){

    return Auth::user()->userNotes()->create([

        'writing_book_id' => $bookId,
        'content' => $content,
    ]);
    
}


public function updateUserNote($note,$content)  {

     
    $note->fill(['content' => $content]);

    if ($note->isDirty('content')) {
  
        $note->save();
    }
}

public function deleteUserNote($note)  {

    $note->delete();

    
}
}