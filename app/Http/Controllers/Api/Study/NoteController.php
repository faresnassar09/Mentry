<?php

namespace App\Http\Controllers\Api\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\NoteRequest;
use App\Http\Resources\Study\NoteResource;
use App\Models\Study\StudyNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $notes = Auth::user()->studyNotes;

        return response()->json(
            [

                'success' => true,
                'message' => 'study notes retrieved successfully',
                'data' => NoteResource::collection($notes),
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteRequest $request)
    {

        try {

            $note = Auth::user()->studyNotes()->create([

                'title' => $request->title,
                'body' => $request->body,
                'study_book_id' => $request->study_book_id ?? null,

            ]);



            Log::channel('userapi')->info('study note created successfully', [

                'user_id' => $note->user_id,
                'note_id' => $note->id,
                'user_ip' => $request->ip(),

            ]);

            return response()->json([

                'success' => true,
                'message' => 'study note created successfully',
                'data' => new NoteResource($note),
            ], 201);
        } catch (\Exception $e) {

            Log::channel('userapi')->info('error occurred while saving study note', [

                'user_id' => Auth::id(),
                'user_ip' => $request->ip(),
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while saving study note',
                'data' => [],
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NoteRequest $note)
    {

        Gate::authorize('view', $note);

        return response()->json([

            'success' => true,
            'message' => 'retrieved study note successfully',
            'data' => new NoteResource($note),

        ], 200);
    }

    
    public function update(StudyNote $note, Request $request)
    {

        Gate::authorize('update', $note);

        try {


            $note->title = $request->title;
            $note->body = $request->body;

            if ($note->isDirty()) {

                $note->save();
            }

            Log::channel('userapi')->info('study note updated successfully', [

                'user_id' => $note->user_id,
                'note_id' => $note->id,
                'user_ip' => $request->ip(),
            ]);

            return response()->json([

                'success' => true,
                'message' => 'study note updated successfully',
                'data' => new NoteResource($note),
            ], 200);
        } catch (\Exception $e) {

            Log::channel('userapi')->info('error occurred while saving study note', [

                'user_id' => Auth::id(),
                'note_id' => $note->id,
                'user_ip' => $request->ip(),
                'exception_details' => $e->getMessage(),
            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while saving study note',
                'data' => new NoteResource($note),
            
            ],500);
     
        }
    }

 
     

    public function destroy(StudyNote $note)
    {
 
         Gate::authorize('delete',$note);

         try {
            
            $note->delete();

            Log::channel('userapi')->info('study note deleted successfully',[
                
                'user_id' => $note->user_id,
                'note_id' => $note->id,
                'note_title' => $note->title,
            ]);

            return response()->json([

                'success' => true,
                'message' => 'study note deleted successfully',
                'data' => [],
    
            ],200);

         } catch (\Exception $e) {

            Log::channel('userapi')->error('error occurred while saving study note',[

                'user_id' => $note->user_id,
                'note_id' => $note->id,
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while saving study note',
                'data' => [],

            ]);

        }

    }
}
