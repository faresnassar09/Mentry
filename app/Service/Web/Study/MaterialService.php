<?php 

namespace App\Service\Web\Study; 

use Illuminate\Support\Facades\Auth;

class MaterialService{

    public function getUserStudyMaterials(){


        return  Auth::user()->studyMaterials()->orderBy('type','asc')->get();
    
    
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

public function updateLastReadTime($material){


    $material->update(['last_read' => now()]);

}
}