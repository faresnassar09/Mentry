<?php

namespace App\Http\Controllers\Study;

use App\Http\Controllers\Controller;
use App\HttP\Requests\Study\Material;
use App\Models\Study\StudyMaterial;
use App\Service\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{

    public function __construct(public FileServices $fileServices) {}

    public function index()
    {
        $title = 'الملخصات و الملازم';

        $materials = Auth::user()->studyMaterials()->orderBy('type','asc')->get();

        return view('users.study.materials.index', compact('title','materials'));
    }

    public function create()
    {

        $title = 'اضافة ملزمة او ملخص';

        return view('users.study.materials.create', compact('title'));
    }


    public function store(Material $request)
    {

        $filePath = $this->fileServices->uploadFile('materials', $request->file('file'));


        $material = $this->insertInDatabase($request->title, $request->type, $filePath);

        if (!$material) {

            return back()->with('failed', 'حدثت مشكلة اثناء التحميل');
        }

        return back()->with('success', 'تم التحميل  بنجاح');
    }

    public function view(StudyMaterial $material)
    {
  
      Gate::authorize('view', $material);

      $title = 'عرض الملخص او الملزمة';
  
      if (!$this->fileServices->checkFileExists($material->path)) {
  
        return back()->with('failed', 'حدث مشكلة اثناء عرض الملف ');
      }
  
  
      $this->updateLastReadTime($material);
  
      $fileUrl = Storage::url($material->path);
  
  
      return view('users.study.materials.view', compact('title','material', 'fileUrl'));
    }


    public function download(StudyMaterial $material ){

        Gate::authorize('download',$material);

          if(!$this->fileServices->checkFileExists($material->path)){

                Log::channel('user')->error('filed to download study material file not found',[ 

                    'user_id' => Auth::user()->id,
                    'material_path' => $material?->path,
                    'material_title' => $material?->title,
                     
                ]);

                return back()->with('failed','حدث خطاء اثناء تحميل الملف'); 
          }

          return $this->fileServices->download($material->path);


    }

    public function delete(StudyMaterial $material){

        Gate::authorize('download', $material);

        $delete = $this->fileServices->delete($material->path);

        if (!$delete) {

            Log::channel('user')->error('error occurred while deleting study material', [
      
              'user_id' => Auth::user()->id,
              'material_id' => $material?->id ?? null,
      
            ]);

            return back()->with('failed', 'حدثت مشكلة اثناء حذف الملف');

    }

    $this->deleteFromDatabase($material);

    return back()->with('success', 'تم حذف الملف بنجاح');

}
    public function insertInDatabase($title, $type, $path)
    {

        try {

            $material = Auth::user()->StudyMaterial()->create([
              
                'title' => $title,
                'path' => $path,
                'type' => $type,
            ]);

            Log::channel('user')->info('material uploaded successfully', [

                'user_id' => $material->user_id,
                'material_id' => $material->id,
                'material_title' => $material->title,
            ]);

            return $material;
        } catch (\Exception $e) {

            Log::channel('user')->error('error occutted while uploading material', [

                'user_id' => Auth::user()->id,
                'material_title' => $title,
                'error_details' => $e->getMessage(),

            ]);

            return false;
        }
    }

    public function updateLastReadTime($material){


        $material->update(['last_read' => now()]);


    }


    public function deleteFromDatabase($material)
    {
  
      try {
  
        $material->delete();
  
        Log::channel('user')->info('study material has been deleted', [
  
          'user_id' => $material->user_id,
          'material_title' => $material->title,
        ]);
      } catch (\Throwable $e) {
  
  
        Log::channel('user')->error('error occurred while deleting study material from database', [
  
          'user_id' => Auth::user()->id,
          'error_details' => $e->getMessage(),
  
        ]);
      }
    }
}
