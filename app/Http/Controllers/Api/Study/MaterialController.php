<?php

namespace App\Http\Controllers\Api\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\MaterialRequest;
use App\Http\Resources\Study\MaterialResource;
use App\Models\Study\StudyMaterial;
use App\Service\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{

    public function __construct(public FileServices $fileServices)
    {
        
    }

    public function index()
    {

    try {

          $materials = Auth::user()->studyMaterials;

            return response()->json([
                'success' => true,
                'message' => 'books retrieved successfully',
                'data' => MaterialResource::collection($materials),
            ]);
 

        } catch (\Exception $e) {


            Log::channel('userapi')->error('error occurred while retrieving study materials',[

                'user_id' => Auth::id(),
                'exception_details' => $e->getMessage(),
            ]);

            return response()->json([
                
                'success' => false,
                'message' => 'error occurred while retrieving study materials',
                'data' => [],
                
            ]);
        }

        

    }

    public function store(MaterialRequest $request)
    {

        try {

            $path = $this->fileServices->uploadFile('materials', $request->file);

            if (!$path) {

                Log::channel('userapi')->error('An error occurred while saving study material on storage', [

                    'user_id' => Auth::id(),
                ]);

                return response()->json([

                    'success' => false,
                    'message' => 'An error occurred while saving study material on storage',
                    'data' => [],

                ], 500);
            }

            $book = Auth::user()->studyMaterials()->create([

                'title' => $request->title,
                'path' => $path,
                'type' => $request->type,

            ]);

            Log::channel('userapi')->info('material book created successfully', [

                'user_id' => $book->user_id,
                'book_id' => $book->id,
            ]);

            return response()->json([

                'success' => true,
                'message' => 'study material created successfully',
                'data' => new MaterialResource($book),

            ], 200);
        } catch (\Exception $e) {

            Log::channel('userapi')->error('error occurred while saving study material', [

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
    public function show(StudyMaterial $material)
    {

        Gate::authorize('view', $material);


        return response()->json([

            'success' => true,
            'message' => 'retrieved study material successfully',
            'data' => new MaterialResource($material),
        ]);

    }

    public function download(StudyMaterial $material)
    {


        Gate::authorize('download', $material);


        try {

            Log::channel('userapi')->info('study material donwloaded successfully', [

                'material_id' => $material->user_id,
                'material_id' => $material->id,
                'user_ip' => request()?->ip(),

            ]);

            return $this->fileServices->download($material->path, $material->title);
        } catch (\Exception $e) {

            Log::channel('userapi')->error('error occurred while downloading study material', [

                'user_id' => $material->user_id,
                'material_id' => $material->id,
                'user_ip' => request()->ip(),
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([
                'success' => false,
                'message' => 'error occurred while donwloading study material',
                'data' => [],
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyMaterial $material)
    {

        Gate::authorize('delete', $material);


        try {

            $status = $this->fileServices->delete($material->path);

            if (!$status) {

                Log::channel('userapi')->error('An error occurred while deleting study material file on storage', [

                    'user_id' => $material->user_id,
                ]);

                return response()->json([

                    'success' => false,
                    'message' => 'error occurred while deleting study material from storage',
                    'data' => [],
                ], 500);
            }

            $material->delete();

            Log::channel('userapi')->info('study material deleted successfully', [

                'user_id' => $material->user_id,
                'book_title' => $material->title,

            ]);

            return response()->json([

                'success' => true,
                'message' => 'study material deleted successfully',
                'data' => [],
            ], 200);
        } catch (\Exception $e) {

            Log::channel('userapi')->info('An error occurred  while deleting study material', [

                'user_id' => $material->user_id,
                'book_title' => $material->title,
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([

                'success' => false,
                'message' => 'An error occurred  while deleting study material',
                'data' => [],
            ], 500);
        }


    }
}
