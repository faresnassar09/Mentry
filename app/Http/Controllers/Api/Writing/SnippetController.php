<?php

namespace App\Http\Controllers\Api\Writing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Writing\SnippetRequest;
use App\Http\Resources\Writing\SnippetResource;
use App\Models\Writing\WritingSnippet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class SnippetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        
        $snippets = Auth::user()->userSnippets()->get();

        return response()->json([

            'success' => true,
            'message' => 'snippet retrieved successfully',
            'data' => SnippetResource::collection($snippets),
        ], 200);

    }


    public function store(SnippetRequest $request)
    {
        try {

            $snippets = Auth::user()->userSnippets()->create([

                'content' => $request->content,
            ]);

            Log::channel('userapi')->info('user snippet created successfully', [

                'user_id' => $snippets->user_id,
                'snippets_id' => $snippets->id,
            ]);


            return response()->json([

                'success' => true,
                'message' => 'user snippet created successfully',
                'data' => new SnippetResource($snippets),
            ], 200);
        } catch (\Exception $e) {


            Log::channel('userapi')->info('error occurred while saving user snippet ', [

                'user_id' => Auth::id(),
                'exception_details' => $e->getMessage(),
            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while saving user snippet',
                'data' => [],
            ], 500);
        }    }


    public function show(WritingSnippet $snippet)
    {

        Gate::authorize('view', $snippet);


        return response()->json([

            'success' => true,
            'message' => 'user snippet retrieved successfully',
            'data' => new SnippetResource($snippet),
        ],200);

    }


    public function update(SnippetRequest $request, WritingSnippet $snippet)
    {
        
        Gate::authorize('update',$snippet);
        try {

            $snippet->fill($request->only(['content']));

            if ($snippet->isDirty('content')) {

                $snippet->save();
            }


            Log::channel('userapi')->info('user snippet updated successfully', [

                'user_id' => $snippet->user_id,
                'user_ip' => $request->ip(),
                'snippet_id' => $snippet->id,

            ]);

            return response()->json([

                'success' => true,
                'message' => 'user snippet updated successfully',
                'data' => new SnippetResource($snippet),
            ], 200);
        } catch (\Exception $e) {


            Log::channel('userapi')->info('error occurred while updating user snippet', [

                'user_id' => $snippet->user_id,
                'user_ip' => $request->ip(),
                'snippet_id' => $snippet->id,
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while updating user snippet',
                'data' => [],
            ], 500);
        }

    }



    public function destroy(WritingSnippet $snippet)
    {


        Gate::authorize('delete', $snippet);

        try {

               $snippet->delete();

         Log::channel('userapi')->info('user snippet deleted successfully', [

                'user_id' => $snippet->user_id,
            ]);


            // sending resource for frontend reference before complete removal from UI

            return response()->json([

                'success' => true,
                'message' => 'user snippet deleted successfully',
                'data' => new SnippetResource($snippet),
            ], 200);
        } catch (\Exception $e) {

            Log::channel('userapi')->error('error occurred while deleting user snippet', [

                'user_id' => $snippet->user_id,
                'exception_details' => $e->getMessage(),
            ]);

            return response()->json([

                'success' => false,
                'message' => 'error occurred while deleting user snippet',
                'data' => [],
            ],500);
        }
    }

    }

