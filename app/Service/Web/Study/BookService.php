<?php

namespace App\Service\Web\Study;

use Illuminate\Support\Facades\Auth;

class BookService{

public function getUserStudyBooks(){


    return  Auth::user()->studyBooks;


}

public function createStudyBook($title, $path)
{

    $book = Auth::user()->studyBooks()->create([

        'title' => $title,
        'path' => $path,
    ]);



    return $book;
}

public function deleteStudyBook($book)
{


    $book->delete();

    return $book;
}

public function updateLastReadTime($book){

    $book->update(['last_read' => now()]);
    
      }

}