<?php

namespace App\Service\Api\Study;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

}