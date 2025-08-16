<?php

namespace App\Http\Controllers\Web\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\BookRequest;
use App\Models\Study\StudyBook;
use App\Service\FileServices;
use App\Service\Web\Logging\LoggingService;
use App\Service\Web\Study\BookService as StudyBookService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{

  public $objectName = 'Study book';

  public function __construct(
    public FileServices  $fileServices,
    public StudyBookService $studyBookService,
    public LoggingService $loggingService,
    
    ) {}

  public function index()
  {

    $books = $this->studyBookService->getUserStudyBooks();
    return view('users.study.books.index', compact('books'));

  }

  public function create()
  {
    return view('users.study.books.create');
  }

  public function store(BookRequest $request)
  {

    try {

      $path = $this->fileServices->uploadFile('study_books', $request->book);

      if (!$path) {

          $this->loggingService->failedLogger($this->objectName, 'uploading', []);

          return back()->with('failed', _('notifications.download_file_failed'));

      }

      $book = $this->studyBookService->createStudyBook($request->title, $path);

      $this->loggingService->successLogger($this->objectName, 'created', [

          'book_id' => $book?->id,
      ]);

      return back()->with('success', __('notifications.book_created_successfully'));

  } catch (\Exception $e) {

      $this->loggingService->failedLogger($this->objectName, 'uploading', [
          'exception_details' => $e->getMessage(),
      ]);

          return back()->with('failed', __('notifications.uploading_file_failed'));

  }      

  }

  public function view(StudyBook $book)
  {

    Gate::authorize('view', $book);

    if (!$this->fileServices->checkFileExists($book->path)) {

      return back()->with('failed', __('notifications.view_file_failed'));
    }

    $this->studyBookService->updateLastReadTime($book);

    $fileUrl = Storage::url($book->path);

    return view('users.study.books.view', compact('book', 'fileUrl'));
  }

  public function download(StudyBook $book)
  {

    Gate::authorize('download', $book);

    try {

        $bookName = $book->title .'.pdf';

        $this->loggingService->successLogger($this->objectName, 'downloaded', [
            'book_id' => $book->id,
        ]);

        return $this->fileServices->download($book->path,$bookName);

    } catch (\Exception $e) {

        $this->loggingService->failedLogger($this->objectName, 'downloading', [
            'book_id' => $book->id,
            'exception_details' => $e->getMessage(),
        ]);

        return back()->with('failed',__('notifications.download_file_failed'));

    }

  }

  public function delete(StudyBook $book)
  {

    Gate::authorize('delete', $book);

    try {

        $status = $this->fileServices->delete($book->path);

        if (!$status) {

            $this->loggingService->failedLogger($this->objectName,'deleting', []);

            return back()->with('failed', __('notifications.delete_file_failed'));
        }

        $this->studyBookService->deleteStudyBook($book);

        $this->loggingService->successLogger($this->objectName,'deleted',[

            'study_book_title' => $book->title,
        ]);

        return back()->with('success', __('notifications.file_deleted_successfully'));

    } catch (\Exception $e) {

        $this->loggingService->successLogger($this->objectName,'deleting',[

    'book_title' => $book->title,
    'exception_details' => $e->getMessage(),
    
    ]);

    return back()->with('failed',  __('notifications.delete_file_failed'));

    }

  }
}