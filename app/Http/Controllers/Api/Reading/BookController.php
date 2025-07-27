<?php

namespace App\Http\Controllers\Api\Reading;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reading\BookResource;
use App\Models\Reading\Book;
use App\Service\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{


    public function __construct(public FileServices $fileServices) {}
    public function index()
    {

        $books = Book::with('category')->paginate(9);


        return response()->json([
            'success' => true,
            'message' => 'Books retrieved successfully',
            'status' => 200,
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

            return response()->json([

                'success' => false,
                'message' => 'error occurred while retrieveing the book ',
                'data' => [],
            ], 500);

            Log::channel()->error('error occurred while retrieving the book', [

                'user_id' => Auth::id(),
                'bbok_id' => $book?->id,
            ]);
        }

        return response()->json([

            'success' => true,
            'message' => 'book retrieved successfully',
            'data' => new BookResource($book),
        ], 200);
    }


    public function download($id)
    {


        try {
            $book = Book::find($id);

            return $this->fileServices->download($book->book_path, $book->title);

        } catch (\Exception $e) {

            Log::channel('userapi')->error('error occurred while retrieving the book', [

                'user_id' => Auth::id(),
                'exception_details' => $e->getMessage(),
            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while retrieveing the book',
                'data' => [],
            ], 500);
        }
    }
}
