<?php

namespace App\Http\Controllers\Web\writing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Writing\BookRequest;
use App\Models\Writing\WritingBook;
use App\Service\FileServices;
use App\Service\Web\Logging\LoggingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Service\Web\Writing\BookService as UserBookService;

class BookController extends Controller
{

    public $objectName = 'User book';

    public function __construct(

        public FileServices $fileServices,
        public LoggingService $loggingService,
        public UserBookService $userBookService,

        ) {}

    public function index()
    {
        $books = $this->userBookService->getUserBooks();

        return view('users.writing.books.index',compact('books'));
    }


    public function create()
    {
        return view('users.writing.books.create');
    }

    public function store(BookRequest $request)
    {

        try {

            $file = $this->fileServices->storeGeneratedFile(

                'users_books',
                $request->title,
                $request->content

            );

            if (!$file['status'] || !$file['path']) {

                $this->loggingService->failedLogger($this->objectName, 'creating', []);

                return back()->with('failed', __('notifications.book_create_failed'));  
            }

            $book =  $this->userBookService->createUserBook($request->title, $file['path']);

            $this->loggingService->successLogger($this->objectName, 'created', [

                'book_id' => $book->id,
            ]);

            return back()->with('success',__('notifications.book_created_successfully'));

        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'creating', [

                'exception_error' => $e->getMessage(),
            ]);

            return back()->with('failed',__('notifications.book_create_failed'));

        }

    }

    public function edit(WritingBook $book)
    {

        Gate::authorize('edit',$book);

        $content = $this->fileServices->getFileContent($book->path);

        return view('users.writing.books.edit',compact('book','content'));

    }

    public function update(WritingBook $book ,Request $request)
    {

 try {

    Gate::authorize('update', $book);

    $status = $this->fileServices->updateExistFileContent($book->path, $request->content);

    if (!$status) {

        $this->loggingService->successLogger($this->objectName, 'updating', []);

        return back()->with('failed',__('notifications.book_update_failed'));
    }

    $this->userBookService->updateUserBook($book, $request->title);

    $this->userBookService->updateLastWriting($book);

    $this->loggingService->successLogger($this->objectName, 'updated', [

        'book_id' => $book->id,
    ]);

    return back()->with('success',__('notifications.book_updated_successfully') );

} catch (\Exception $e) {

    $this->loggingService->failedLogger($this->objectName, 'updating', [

        'book_id' => $book->id,
        'exception_details' => $e->getMessage(),
    ]);

    return back()->with('failed',__('notifications.book_update_failed'));

        }
    }

    public function download(WritingBook $book){


 Gate::authorize('download',$book);

 $this->loggingService->successLogger($this->objectName, 'downloaded', [

    'book_id' => $book->id,
]);

 return $this->fileServices->generatePdfFile($book->path,$book->title);

    }

    public function delete(WritingBook $book){





    try {
    Gate::authorize('delete', $book);

        $status = $this->fileServices->delete($book->path);

        if (!$status) {

             $this->loggingService->failedLogger($this->objectName, 'deleting', []);

             return back()->with('failed',__('notifications.book_update_failed'));
        }

        $this->loggingService->successLogger($this->objectName, 'deleted', []);

        $this->userBookService->deleteUserBook($book);

        return back()->with('success',__('notifications.book_delete_failed'));

    } catch (\Exception $e) {

        $this->loggingService->failedLogger($this->objectName, 'deleting', [

            'book_title' => $book->title,
            'exception_details' => $e->getMessage(),
        ]);

        return back()->with('failed',__('notifications.book_delete_failed'));

    }

    }

}
