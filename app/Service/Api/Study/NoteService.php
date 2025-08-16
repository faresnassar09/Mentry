<?php
namespace App\Service\Api\Study;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class NoteService{

    public function getUserStudyNotes(){

        return  Auth::user()->studyNotes;
        
    }
    
    public function createStudyNote($title,$body,$studyBookId = null){

   return Auth::user()->studyNotes()->create([

        'title' => $title,
        'body' => $body,
        'study_book_id' => $studyBookId ,

    ]);

    }

    public function updateStudyNote($note,$data) {
        
        $note->fill($data->only(['title', 'body']));

        if ($note->isDirty()) {

            $note->save();
        }
    }

    public function deleteStudyNote($note){

        $note->delete();

    }

}