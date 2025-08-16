<?php

namespace App\Http\Controllers\Web\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\MaterialRequest;
use App\Models\Study\StudyMaterial;
use App\Service\FileServices;
use App\Service\Web\Logging\LoggingService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Service\Web\Study\MaterialService as StudyMaterialService;

class MaterialController extends Controller
{

  public $objectName = "Study Material";
    public function __construct(
      
      public FileServices $fileServices,
      public StudyMaterialService $studyMaterialService,
      public LoggingService $loggingService,
      
      ) {}

    public function index()
    {
      $materials = $this->studyMaterialService->getUserStudyMaterials();

        return view('users.study.materials.index', compact('materials'));
    }

    public function create()
    {

      return view('users.study.materials.create');
    }

    public function store(MaterialRequest $request)
    {

      try {

        $path = $this->fileServices->uploadFile('materials', $request->file);

        if (!$path) {

            $this->loggingService->failedLogger($this->objectName, 'creating', []);

            return back()->with('failed',__('notifications.download_file_failed'));
        }

        $material = $this->studyMaterialService->createStudyMaterial(

            $request->title,
            $request->type,
            $path
        );

        $this->loggingService->successLogger($this->objectName,'created',[

            'material_id' => $material->id,
        ]);

        return back()->with('success', __('notifications.material_created_successfully'));

    } catch (\Exception $e) {

        $this->loggingService->successLogger($this->objectName, 'storing', [

            'exception_details' => $e->getMessage(),

        ]);

        return back()->with('failed', __('notifications.download_file_failed'));

    }

    }

    public function view(StudyMaterial $material)
    {
  
      Gate::authorize('view', $material);
  
      if (!$this->fileServices->checkFileExists($material->path)) {
  
        return back()->with('failed', __('notifications.view_file_failed'));
      }
  
      $this->studyMaterialService->updateLastReadTime($material);
  
      $fileUrl = Storage::url($material->path);
  
      return view('users.study.materials.view', compact('material', 'fileUrl'));
    }

    public function download(StudyMaterial $material ){

          try {

            Gate::authorize('download',$material);

              $this->loggingService->successLogger($this->objectName, 'downloaded', [
  
                  'material_id' => $material->id
              ]);
  
              return $this->fileServices->download($material->path, $material->title.'.pdf');

          } catch (\Exception $e) {
  
              $this->loggingService->failedLogger($this->objectName, 'downloading', [
  
                  'material_id' => $material->id,
                  'exception_details' => $e->getMessage(),
  
              ]);
  
                  return back()->with('failed',__('notifications.download_file_failed')); 

          }
    }

    public function delete(StudyMaterial $material){

     try {
            
        Gate::authorize('delete', $material);

            $status = $this->fileServices->delete($material->path);

            if (!$status) {

                $this->loggingService->failedLogger($this->objectName, 'deleting', []);

                return back()->with('failed', __('notifications.delete_file_failed'));

            }

            $this->studyMaterialService->deleteStudyMaterial($material);

            $this->loggingService->successLogger($this->objectName,'deleted',[

                'material_title' => $material->title,
            ]);

          return back()->with('success', __('notifications.file_deleted_successfully'));

        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'deleting', [

                'material_title' => $material->title,
                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed', __('notifications.delete_file_failed'));

        }
}

}
