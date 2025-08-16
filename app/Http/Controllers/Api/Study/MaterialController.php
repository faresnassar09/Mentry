<?php

namespace App\Http\Controllers\Api\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\MaterialRequest;
use App\Http\Resources\Study\MaterialResource;
use App\Models\Study\StudyMaterial;
use App\Service\Api\Logging\LoggingService;
use App\Service\Api\ResponseHandelerService;
use App\Service\FileServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Service\Api\Study\MaterialService as StudyMaterialService;

class MaterialController extends Controller
{

    public $objectName = 'Study Material';

    public function __construct(

        public FileServices $fileServices,
        public ResponseHandelerService $responseHandelerService,
        public StudyMaterialService $studyMaterialService,
        public LoggingService $loggingService,

    ) {}

    public function index()
    {


        $materials = $this->studyMaterialService->getUserStudyMaterials();

        return $this->responseHandelerService->successResponse(

            "{$this->objectName} retrieved successfully",
            MaterialResource::collection($materials),
            200
        );
    }

    public function store(MaterialRequest $request)
    {

        try {

            $path = $this->fileServices->uploadFile('materials', $request->file);

            if (!$path) {

                $this->loggingService->failedLogger($this->objectName, 'creating', []);

                return $this->responseHandelerService->failedResponse(

                    "Unexpected error occurred while retriveing {$this->objectName} from storage",
                    [],
                    500
                );
            }

            $material = $this->studyMaterialService->createStudyMaterial(

                $request->title,
                $request->type,
                $path
            );

            $this->loggingService->successLogger($this->objectName,'created',[

                'material_id' => $material->id,
            ]);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} created successfully",
                new MaterialResource($material),
                200,
            );
        } catch (\Exception $e) {

            $this->loggingService->successLogger($this->objectName, 'storing', [

                'exception_details' => $e->getMessage(),

            ]);

            return $this->responseHandelerService->failedResponse(

                "Unexpected error occurred while storig {$this->objectName}",
                [],
                500
            );
        }
    }

    public function show(StudyMaterial $material)
    {

        Gate::authorize('view', $material);


        if (!$this->fileServices->checkFileExists($material->path)) {
  
            return $this->responseHandelerService->failedResponse(

                "error occurred while view {$this->objectName}",
                new MaterialResource($material),
                500
            ); 
        
        }

        $this->studyMaterialService->updateLastReadTime($material);

        return $this->responseHandelerService->successResponse(

            "{$this->objectName} retrieved successfully",
            new MaterialResource($material),
            200
        );
    }

    public function download(StudyMaterial $material)
    {

        Gate::authorize('download', $material);


        try {

            $this->loggingService->successLogger($this->objectName, 'downloaded', [

                'material_id' => $material->id
            ]);

            return $this->fileServices->download($material->path, $material->title);
        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'downloading', [

                'material_id' => $material->id,
                'exception_details' => $e->getMessage(),

            ]);

            return $this->responseHandelerService->failedResponse(

                "Unexpected error occurred while downloading {$this->objectName}",
                [],
                500
            );
        }
    }


    public function destroy(StudyMaterial $material)
    {



        try {
            
        Gate::authorize('delete', $material);

            $status = $this->fileServices->delete($material->path);

            if (!$status) {

                $this->loggingService->failedLogger($this->objectName, 'deleting', []);

                return $this->responseHandelerService->failedResponse(

                    "Unexpected error occurred while deleting {$this->objectName}",
                    [],
                    500
                );
            }

            $this->studyMaterialService->deleteStudyMaterial($material);

            $this->loggingService->successLogger($this->objectName,'deleted',[

                'material_title' => $material->title,
                
            ]);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} deleted successfully",
                [],
                200
            );
        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'deleting', [

                'material_title' => $material->title,
                'exception_details' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Unexpected error occurred while deleting {$this->objectName}",

                [],
                500
            );
        }
    }
}
