<?php 

namespace App\Service\Api\Study; 

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MaterialService{

    public function getUserStudyMaterials(){


        return  Auth::user()->studyMaterials;
    
    
    }


    public function createStudyMaterial($title,$type,$path)
{

    $material = Auth::user()->studyMaterials()->create([

        'title' => $title,
        'path' => $path,
        'type' => $type,

    ]);

    return $material;
}


public function deleteStudyMaterial($material)
{

    $material->delete();

    return $material;
}

}