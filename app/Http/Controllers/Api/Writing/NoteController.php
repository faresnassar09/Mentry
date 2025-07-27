<?php

namespace App\Http\Controllers\Api\Writing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Writing\NoteRequest;
use App\Http\Requests\Writing\NoteUpdateRequest;
use App\Http\Resources\Writing\NoteResource;
use App\Models\Writing\WritingBook;
use App\Models\Writing\WritingNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{

    public function index()
    {

        $notes = Auth::user()->userNotes()->with('writingBook')->get();

        return response()->json([

            'success' => true,
            'message' => 'notes retrieved successfully',
            'data' => NoteResource::collection($notes),
        ], 200);
    }


    public function store(NoteRequest $request)
    {


        if(!WritingBook::find($request->book_id)){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized action',
                'data' => [],
            ],403);
        }


        try {

            $note = Auth::user()->userNotes()->create([

                'writing_book_id' => $request->book_id,
                'content' => $request->content,
            ]);

            Log::channel('userapi')->info('user note created successfully', [

                'user_id' => $note->user_id,
                'note_id' => $note->id,
            ]);


            return response()->json([

                'success' => true,
                'message' => 'user note created successfully',
                'data' => new NoteResource($note),
            ], 200);
        } catch (\Exception $e) {


            Log::channel('userapi')->info('error occurred while saving user note ', [

                'user_id' => Auth::id(),
                'exception_details' => $e->getMessage(),
            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while saving user note',
                'data' => [],
            ], 500);
        }
    }


    public function show(WritingNote $note)
    {

        Gate::authorize('view', $note);


        return response()->json([

            'success' => true,
            'message' => 'user note retrieved successfully',
            'data' => new NoteResource($note),
        ],200);
    }


    public function update(NoteUpdateRequest $request,WritingNote $note)
    {

        Gate::authorize('update',$note);
        try {

            $note->fill($request->only(['content']));

            if ($note->isDirty('content')) {

                $note->save();
            }


            Log::channel('userapi')->info('user note updated successfully', [

                'user_id' => $note->user_id,
                'user_ip' => $request->ip(),
                'note_id' => $note->id,

            ]);

            return response()->json([

                'success' => true,
                'message' => 'user note updated successfully',
                'data' => new NoteResource($note),
            ], 200);
        } catch (\Exception $e) {


            Log::channel('userapi')->info('error occurred while updating user note', [

                'user_id' => $note->user_id,
                'user_ip' => $request->ip(),
                'note_id' => $note->id,
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while updating user note',
                'data' => [],
            ], 500);
        }

    }


    public function destroy(WritingNote $note)
    {

        Gate::authorize('delete', $note);

        try {

               $note->delete();

         Log::channel('userapi')->info('user note deleted successfully', [

                'user_id' => $note->user_id,
            ]);


            // sending resource for frontend reference before complete removal from UI

            return response()->json([

                'success' => true,
                'message' => 'user note deleted successfully',
                'data' => new NoteResource($note),
            ], 200);
        } catch (\Exception $e) {

            Log::channel('userapi')->error('error occurred while deleting user note', [

                'user_id' => $note->user_id,
                'exception_details' => $e->getMessage(),
            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while deleting user note',
                'data' => [],
            ],500);
        }
    }
}
