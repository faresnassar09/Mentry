<?php

namespace App\Http\Controllers\Api\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\BookRequest;
use App\Http\Resources\Study\BookResource;
use App\Models\Study\StudyBook;
use App\Service\Api\Logging\LoggingService;
use App\Service\Api\ResponseHandelerService;
use App\Service\Api\Study\BookService as StudyBookService;
use App\Service\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{

    public $objectName = 'Study book';
    public function __construct(

        public FileServices $fileServices,
        public StudyBookService $studyBookService,
        public ResponseHandelerService $responseHandelerService,
        public LoggingService $loggingService,
    ) {}

    public function index()
    {

        $books = $this->studyBookService->getUserStudyBooks();

        return $this->responseHandelerService->successResponse(
            'Study books retrieved successfully',
            BookResource::collection($books),
            200
        );
    }

    public function store(BookRequest $request)
    {

        try {

            $path = $this->fileServices->uploadFile('study_books', $request->book);

            if (!$path) {

                $this->loggingService->failedLogger($this->objectName, 'uploading', []);

                return $this->responseHandelerService->failedResponse(
                    'Unexpected error occurred while storing study book',
                    [],
                    500
                );
            }

            $book = $this->studyBookService->createStudyBook($request->title, $path);

            $this->loggingService->successLogger($this->objectName, 'created', [

                'book_id' => $book?->id,
            ]);

            return $this->responseHandelerService->successResponse(
                'Study book created successfully',
                new BookResource($book),
                201
            );
        } catch (\Exception $e) {


            $this->loggingService->failedLogger($this->objectName, 'uploading', [
                'exception_details' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(
                'Unexpected error occurred while storing study book',
                [],
                500
            );
        }
    }

    public function show(StudyBook $book)
    {

        Gate::authorize('view', $book);


        if (!$this->fileServices->checkFileExists($book->path)) {

            return $this->responseHandelerService->failedResponse(
                'Error occurred while retrieve Study book',
                new BookResource($book),
                500
            );
         }
      
         $this->studyBookService->updateLastReadTime($book);

        return $this->responseHandelerService->successResponse(
            'Study book retrieved  successfully',
            new BookResource($book),
            200
        );
    }
    public function download(StudyBook $book)
    {
        Gate::authorize('download', $book);


        try {

            $this->loggingService->successLogger($this->objectName, 'downloaded', [
                'book_id' => $book->id,
            ]);

            return $this->fileServices->download($book->path, $book->name);

        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'downloading', [
                'book_id' => $book->id,
                'exception_details' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(
                'Unexpected error occurred while downloading study book',
                [],
                500
            );
        }
    }



    public function destroy(StudyBook $book)
    {
        Gate::authorize('delete', $book);

        try {

            $status = $this->fileServices->delete($book->path);

            if (!$status) {

                $this->loggingService->failedLogger($this->objectName,'deleting', []);

                return $this->responseHandelerService->failedResponse(
                    'Unexpected error occurred while deleting study book from system storage',
                    [],
                    500
                );
            }

            $this->studyBookService->deleteStudyBook($book);

            $this->loggingService->successLogger($this->objectName,'deleted',[

                'study_book_title' => $book->title,
            ]);


            return $this->responseHandelerService->successResponse(
                'Study book deleted successfully',
                new BookResource($book),
                200
            );


        } catch (\Exception $e) {

            $this->loggingService->successLogger($this->objectName,'deleting',[

        'book_title' => $book->title,
        'exception_details' => $e->getMessage(),
        
        ]);

        return $this->responseHandelerService->failedResponse(
                'Unexpected error occurred while deleting study book',
                [],
                500
            );
        }
    }
} 
