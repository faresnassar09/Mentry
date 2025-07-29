<?php

namespace App\Http\Controllers\Api\Writing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Writing\BookRequest;
use App\Http\Resources\Writing\BookResource;
use App\Http\Resources\Writing\DetailedBookResource;
use App\Models\Writing\WritingBook;
use App\Service\Api\Logging\LoggingService;
use App\Service\Api\ResponseHandelerService;
use App\Service\FileServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Service\Api\Writing\BookService as UserBookService;

class BookController extends Controller
{

    public $objectName = 'User book';
    public function __construct(

        public FileServices $fileServices,
        public UserBookService $userBookService,
        public ResponseHandelerService $responseHandelerService,
        public LoggingService $loggingService,
    ) {}


    public function index()
    {

        $books = $this->userBookService->getUserBooks();

        return $this->responseHandelerService->successResponse(

            "{$this->objectName}s retrieved successfully",
            BookResource::collection($books),
            200
        );
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

                return $this->responseHandelerService->failedResponse(

                    "Unexpected error occurred while saving {$this->objectName} in system storage",
                    [],
                    500
                );
            }

            $book =  $this->userBookService->createUserBook($request->title, $file['path']);

            $this->loggingService->successLogger($this->objectName, 'created', [

                'book_id' => $book->id,
            ]);


            return $this->responseHandelerService->successResponse(

                "$this->objectName created successfully",
                new BookResource($book),
                200
            );
        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'creating', [

                'exception_error' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Unexpected error occurred while saving {$this->objectName}",
                [],
                500
            );
        }
    }


    public function show(WritingBook $book)
    {

        Gate::authorize('view', $book);

        return $this->responseHandelerService->successResponse(

            "$this->objectName retrieved successfully",
            new DetailedBookResource($book),
            200
        );
    }

    public function update(BookRequest $request, WritingBook $book)
    {

        Gate::authorize('update', $book);

        try {

            $status = $this->fileServices->updateExistFileContent($book->path, $request->content);

            if (!$status) {

                $this->loggingService->successLogger($this->objectName, 'updating', []);

                return $this->responseHandelerService->failedResponse(

                    "Unexpected error occurred while updating {$this->objectName}",
                    [],
                    500
                );
            }

            $this->userBookService->updateUserBook($book, $request->title);

            $this->loggingService->successLogger($this->objectName, 'updated', [

                'book_id' => $book->id,
            ]);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} updated successfully",
                new BookResource($book),
                200
            );
        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'updating', [

                'book_id' => $book->id,
                'exception_details' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Unexpected Error occurred while updating $this->objectName",
                [],
                500
            );
        }
    }


    public function destroy(WritingBook $book)
    {

        Gate::authorize('delete', $book);

        try {

            $status = $this->fileServices->delete($book->path);

            if (!$status) {

                $this->loggingService->failedLogger($this->objectName, 'deleting', []);

                return $this->responseHandelerService->successResponse(

                    "Unexpcted Error occurred while deleting {$this->objectName} from system storage",
                    [],
                    500
                );
            }

            $this->loggingService->successLogger($this->objectName, 'deleted', []);

            $this->userBookService->deleteUserBook($book);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} deleted successfully",
                new BookResource($book),
                200
            );
        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'deleting', [

                'book_title' => $book->title,
                'exception_details' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Unexpected error occurred while deleting $this->objectName",
                [],
                500
            );
        }
    }


    public function download(WritingBook $book)
    {

        Gate::authorize('download', $book);

        $this->loggingService->successLogger($this->objectName, 'downloaded', [

            'book_id' => $book->id,
        ]);

        return $this->fileServices->generatePdfFile($book->path, $book->title);
    }
}
