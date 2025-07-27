<?php

namespace App\Http\Controllers\Api\Study;

use App\Filament\Resources\BookResource as ResourcesBookResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Study\BookRequest;
use App\Http\Resources\Study\BookResource;
use App\Models\Study\StudyBook;
use App\Service\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{

    public function __construct(public FileServices $fileServices) {}

    public function index()
    {

        try {

            $books = Auth::user()->studyBooks;

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Study books retrieved successfully',
                    'data' => BookResource::collection($books),
                ],
                200
            );
        } catch (\Exception $e) {


            Log::channel('userapi')->error('An error occurred while retrieving study books', [

                'user_id' => Auth::id(),
                'user_ip' => request()?->ip(),
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving study books',
                'data' => [],
            ], 500);
        }
    }

    public function store(BookRequest $request)
    {

        try {

            $path = $this->fileServices->uploadFile('study_books', $request->book);

            if (!$path) {

                Log::channel('userapi')->error('An error occurred while saving study book file on storage', [

                    'user_id' => Auth::id(),
                ]);

                return response()->json([

                    'success' => false,
                    'message' => 'An error occurred while saving study book file on storage',
                    'data' => [],

                ], 500);
            }

            $book = Auth::user()->studyBooks()->create([

                'title' => $request->title,
                'path' => $path,
            ]);

            Log::channel('userapi')->info('study book created successfully', [

                'user_id' => $book->user_id,
                'book_id' => $book->id,
            ]);

            return response()->json([

                'success' => true,
                'message' => 'study book created successfully',
                'data' => new BookResource($book),

            ], 200);
        } catch (\Exception $e) {

            Log::channel('userapi')->error('error occurred while saving study book', [

                'user_id' => Auth::id(),
                'exception_details' => $e->getMessage(),
                'user_ip' => request()?->ip(),

            ]);

            return response()->json([
                'success' => false,
                'message' => 'error occurred while saving study book'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StudyBook $book)
    {

        Gate::authorize('view', $book);


        return response()->json([

            'success' => true,
            'message' => 'retrieved study book successfully',
            'data' => new BookResource($book),
        ]);
    }


    public function download(StudyBook $book)
    {


        Gate::authorize('download', $book);


        try {

            Log::channel('userapi')->info('study book donwloaded successfully', [

                'user_id' => $book->user_id,
                'book_id' => $book->id,
                'user_ip' => request()?->ip(),

            ]);

            return $this->fileServices->download($book->path, $book->name);
        } catch (\Exception $e) {

            Log::channel('userapi')->error('error occurred while downloading study book', [

                'user_id' => $book->user_id,
                'book_id' => $book->id,
                'user_ip' => request()->ip(),
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([
                'success' => false,
                'message' => 'error occurred while donwloading study book',
                'data' => [],
            ]);
        }
    }



    public function destroy(StudyBook $book)
    {
        Gate::authorize('delete', $book);

        try {

            $status = $this->fileServices->delete($book->path);

            if (!$status) {

                Log::channel('userapi')->error('An error occurred while deleting study book file on storage', [

                    'user_id' => $book->user_id,
                ]);

                return response()->json([

                    'success' => false,
                    'message' => 'error occurred while deleting study book from storage',
                    'data' => [],
                ], 500);
            }

            $book->delete();

            Log::channel('userapi')->info('study book deleted successfully', [

                'user_id' => $book->user_id,
                'book_title' => $book->title,

            ]);

            return response()->json([

                'success' => true,
                'message' => 'study book deleted successfully',
                'data' => [],
            ], 200);
        } catch (\Exception $e) {

            Log::channel('userapi')->info('An error occurred  while deleting study book', [

                'user_id' => $book->user_id,
                'book_title' => $book->title,
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([

                'success' => false,
                'message' => 'An error occurred  while deleting study book',
                'data' => [],
            ], 500);
        }
    }
}
