<?php

namespace App\Http\Controllers\Api\Writing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Writing\BookRequest;
use App\Http\Resources\Writing\BookResource;
use App\Http\Resources\Writing\DetailedBookResource;
use App\Models\Writing\WritingBook;
use App\Service\FileServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{

    public function __construct(public FileServices $fileServices) {}


    public function index()
    {


        $books = Auth::user()->userBooks;

        return response()->json([

            'success' => true,
            'message' => 'books retrieved successfully',
            'data' => BookResource::collection($books),
        ], 200);
    }



    public function store(BookRequest $request)
    {

        try {

            $book = $this->fileServices->storeGeneratedFile(

                'users_books',
                $request->title,
                $request->content

            );

            if (!$book['status'] || !$book['path']) {


                Log::channel('userapi')->error('error occurred while saving user book in system storage', [

                    'user_id' => Auth::id(),
                ]);

                return response()->json([

                    'success' => false,
                    'message' => 'error occurred while saving user book in system storage',
                    'data' => [],

                ], 500);
            }

            $book =  Auth::user()->userBooks()->create([

                'title' => $request->title,
                'path' => $book['path'],
            ]);

            Log::channel('userapi')->info('user book created successfully', [

                'user_id' => $book->user_id,
                'book_id' => $book->id,
            ]);

            return response()->json([

                'success' => true,
                'message' => 'user book created successfully',
                'data' => new BookResource($book),
            ], 201);
        } catch (\Exception $e) {


            Log::channel('userapi')->error('error occurred while saving user book', [

                'user_id' => Auth::id(),
                'exception_error' => $e->getMessage(),

            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while saving user book',
                'data' => [],
            ], 500);
        }
    }


    public function show(WritingBook $book)
    {

        Gate::authorize('view', $book);

        return response()->json([

            'success' => true,
            'message' => 'user book retrieved successfully',
            'data' => new DetailedBookResource($book),
        ]);
    }



    public function update(WritingBook $request, WritingBook $book)
    {

        Gate::authorize('update', $book);

        try {

            $status = $this->fileServices->updateExistFileContent($book->path, $request->content);

            if (!$status) {

                Log::channel('userapi')->error('error occurred while updating user book in system storage', [

                    'user_id' => $book->user_id,
                ]);

                return response()->json([

                    'success' => false,
                    'message' => 'error occurred while updating user book',
                    'data' => [],

                ]);
            }


            $book->fill($request->only(['title',]));

            if ($book->isDirty('title')) {

                $book->save();
            }


            Log::channel('userapi')->info('user book updated successfully', [

                'user_id' => $book->user_id,
                'user_ip' => $request->ip(),
                'book_id' => $book->id,

            ]);

            return response()->json([

                'success' => true,
                'message' => 'user book updated successfully',
                'data' => new BookResource($book),
            ], 200);
        } catch (\Exception $e) {


            Log::channel('userapi')->info('error occurred while updating user book', [

                'user_id' => $book->user_id,
                'user_ip' => $request->ip(),
                'book_id' => $book->id,
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while updating user book',
                'data' => [],
            ], 500);
        }
    }


    public function destroy(WritingBook $book)
    {

        Gate::authorize('delete', $book);

        try {

            $status = $this->fileServices->delete($book->path);

            if (!$status) {

                Log::channel('userapi')->error('error occurred while deleting user book from system storage', [

                    'user_id' => $book->user_id,
                    'book_id' => $book->id,
                ]);

                return response()->json([

                    'success' => false,
                    'message' => 'error occurred while deleting user book from system storage',
                    'data' => [],
                ], 500);
            }

            Log::channel('userapi')->info('user book deleted successfully', [

                'user_id' => $book->user_id,
                'book_id' => $book->id,
            ]);

            $book->delete();

            // sending resource for frontend reference before complete removal from UI

            return response()->json([

                'success' => true,
                'message' => 'user book deleted successfully',
                'data' => new BookResource($book),
            ], 200);
        } catch (\Exception $e) {

            Log::channel('userapi')->error('error occurred while deleting user book', [

                'user_id' => $book->user_id,
                'book_title' => $book->title,
                'exception_details' => $e->getMessage(),
            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while deleting user book',
                'data' => [],
            ]);
        }
    }


    public function download(WritingBook $book)
    {

        Gate::authorize('download', $book);
  
        Log::channel('userapi')->info('user book downloaded successfully',[

            'user_id' => $book->user_id,
            'user_ip' => request()->ip(),
            'book_id' => $book->id,  

        ]);

        return $this->fileServices->generatePdfFile($book->path,$book->title);
    }
}

