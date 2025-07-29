<?php
namespace App\Service\Api\Writing;

use Illuminate\Support\Facades\Auth;

class BookService{

public function getUserBooks() {

   return  Auth::user()->userBooks;

    
}


public function createUserBook($title,$path)  {

    return Auth::user()->userBooks()->create([

        'title' => $title,
        'path' => $path,    
    ]);

}

public function updateUserBook($book,$title){

    
    $book->fill((['title' => $title]));

    if ($book->isDirty(['title'])) {

        $book->save();
    }

}

 public function deleteUserBook($book)  {

    $book->delete();


}   
}
 
