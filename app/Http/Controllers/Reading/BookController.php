<?php

namespace App\Http\Controllers\Reading;

use App\Http\Controllers\Controller;
use App\Models\Reading\Book;
use App\Service\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{

    public function __construct(public FileServices $fileServices){}

public function index(){

    $title = 'الكتب';
    $books = Book::with('category')->paginate(9);



return view('users.reading.books.index',compact('title','books'));

}


public function read(Book $book)
{


$title = 'عرض الكتاب';

  if (!$this->fileServices->checkFileExists($book->book_path)) {

    return back()->with('failed', 'حدث مشكلة اثناء عرض الملف ');
  }


  $fileUrl = Storage::url($book->book_path);

  return view('users.reading.books.view', compact('title','book', 'fileUrl'));
}

public function download(Book $book)
{


  if (!$this->fileServices->checkFileExists($book->book_path)) {

    Log::channel('user')->error('The file does not exist', [

      'user_id' => Auth::user()->id,
      'path' => $book?->book_path ?? null
    ]);

    return back()->with('failed', 'حدث مشكلة اثناء تحميل الملف ');
  }

  Log::channel('user')->info('user download book successfully ', [
    'user_id' => Auth::user()->id,
    'book_id' => $book->id
  ]);

  $bookName = $book->title.'.pdf';

  return $this->fileServices->download($book->book_path,$bookName);
}

}
