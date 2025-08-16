<?php

namespace App\Http\Controllers\Web\Reading;

use App\Http\Controllers\Controller;
use App\Models\Reading\Book;
use App\Service\FileServices;
use App\Service\Web\Logging\LoggingService;


class BookController extends Controller
{

  public function __construct(

    public FileServices $fileServices,
    public LoggingService $loggingService,

  ) {}

  public function index()
  {

    $books = Book::with('category')->paginate(9);

    return view('users.reading.books.index', compact('books'));
  }

  public function read(Book $book)
  {

    if (!$this->fileServices->checkFileExists($book->book_path)) {

      $this->loggingService->failedLogger('books', 'retrirving', [

        'error' => 'book not found'
      ]);

      return back()->with('failed',__('notifications.view_file_failed'));
    }

    return view('users.reading.books.view', compact('book'));
  }

  public function download(Book $book)
  {

    try {

      $this->loggingService->successLogger('User book', 'downloaded', [

        'book_id' => $book->id

      ]);

      $bookName = $book->title . '.pdf';

      return $this->fileServices->download($book->book_path, $bookName);

    } catch (\Exception $e) {

      $this->loggingService->failedLogger('books', 'downloading', [

        'exception_details' => $e->getMessage(),

      ]);

      return back()->with('failed', __('notifications.download_file_failed'));
    }
  }
}
