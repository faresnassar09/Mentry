<?php

namespace App\Http\Controllers\Api\Reading;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reading\BookResource;
use App\Models\Reading\Book;
use App\Service\Api\Logging\LoggingService;
use App\Service\Api\ResponseHandelerService;
use App\Service\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{


    public function __construct(

        public FileServices $fileServices,
        public ResponseHandelerService $responseHandelerService,
        public LoggingService $loggingService,

    ) {}
    public function index()
    {

        $books = Book::with('category')->paginate(9);


        return $this->responseHandelerService->successResponse('Books retrieved successfully', [

            'data' => BookResource::collection($books),
            'links' => [
                'first' => $books->url(1),
                'last' => $books->url($books->lastPage()),
                'prev' => $books->previousPageUrl(),
                'next' => $books->nextPageUrl(),
            ],
            'meta' => [

                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),

            ]
        ], 200);
    }

    public function show($id)
    {

        $book = Book::find($id);

        if (!$book) {

            $this->loggingService->failedLogger('books', 'retrirving', [

                'error' => 'book not found'
            ]);

            return $this->responseHandelerService->failedResponse(

                'Error occurred while retrieveing books',
                [],
                500
            );
        }

        return $this->responseHandelerService->successResponse(

            'book retrieved successfully',
            new BookResource($book),
            200
        );
    }

    public function download($id)
    {


        try {

            $book = Book::find($id);

            return $this->fileServices->download($book->book_path, $book->title);
            
        } catch (\Exception $e) {


            $this->loggingService->failedLogger('books', 'downloading', [

            'exception_details' => $e->getMessage(),

            ]);

            return $this->responseHandelerService->failedResponse(

                'Error occurred while downloading book',
                [],
                500
            );
        }
    }
}
