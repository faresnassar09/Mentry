<?php

namespace App\Http\Controllers\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\Book;
use App\Models\Study\StudyBook;
use App\Models\User;
use App\Service\FileServices;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{

  use AuthorizesRequests;
  public function __construct(public FileServices  $fileServices) {}

  public function index()
  {

    $title = 'الكتب الدراسية';

    $books = Auth::user()->studyBooks;

    return view('users.study.books.index', compact('title', 'books'));
  }


  public function create()
  {

    $title = 'اضافة كتاب مذاكرة';
    return view('users.study.books.create', compact('title'));
  }


  public function store(Book $request)
  {

    $filePath = $this->fileServices->uploadFile('study_books', $request->file('book'));

    $book = $this->insertInDatabase($request->title, $filePath);

    if (!$book) {

      return back()->with('failed', 'حدثت مشكلة اثناء تحميل الكتاب');
    }

    return back()->with('success', 'تم اضافة الكتاب بنجاح');
  }


  public function view(StudyBook $book)
  {

    Gate::authorize('view', $book);



    if (!$this->fileServices->checkFileExists($book->path)) {

      return back()->with('failed', 'حدث مشكلة اثناء عرض الملف ');
    }


    $this->updateLastReadTime($book);

    $fileUrl = Storage::url($book->path);


    return view('users.study.books.view', compact('book', 'fileUrl'));
  }

  public function download(StudyBook $book)
  {

    Gate::authorize('download', $book);

    if (!$this->fileServices->checkFileExists($book->path)) {

      Log::channel('user')->error('The file does not exist', [

        'user_id' => Auth::user()->id,
        'path' => $book?->path ?? null
      ]);

      return back()->with('failed', 'حدث مشكلة اثناء تحميل الملف ');
    }

    Log::channel('user')->info('Study book downloaded successfully', [
      'user_id' => Auth::user()->id,
      'book_id' => $book->id
    ]);

    $bookName = $book->title .'.pdf';

    return $this->fileServices->download($book->path,$bookName);
  }

  public function delete(StudyBook $book)
  {


    Gate::authorize('delete', $book);

    $delete = $this->fileServices->delete($book->path);

    if (!$delete) {

      Log::channel('user')->error('error occurred while deleting the file', [

        'user_id' => Auth::user()->id,
        'book_id' => $book?->id ?? null,

      ]);

      return back()->with('failed', 'فشل حذف الملف');
    }

    $this->deleteFromDatabase($book);

    return back()->with('success', 'تم حذف الملف بنجاح');
  }


  public function insertInDatabase($title, $path)
  {

    try {

      $studyBook = Auth::user()->StudyBooks()->create([

        'title' => $title,
        'path' => $path,
      ]);

      Log::channel('user')->info('study_book has created', [

        'user_id' => $studyBook->user_id,
        'book_id' => $studyBook->id

      ]);

      return $studyBook;
    } catch (\Exception $e) {

      Log::channel('user')->error('error occurred while uploading study_book', [

        'user_id' => Auth::user()->id,
        'error_details' => $e->getMessage(),

      ]);
    }
  }

  public function deleteFromDatabase($book)
  {

    try {

      $book->delete();

      Log::channel('user')->info('book has been deleted', [

        'user_id' => Auth::user()->id,
        'book_title' => $book->title,
      ]);
    } catch (\Throwable $e) {


      Log::channel('user')->error('error occurred while deleting from database', [

        'user_id' => Auth::user()->id,
        'error_details' => $e->getMessage(),

      ]);
    }
  }

  public function updateLastReadTime($book){

$book->update(['last_read' => now()]);

  }
}
