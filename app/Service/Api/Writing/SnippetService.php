<?php

namespace App\Service\Api\Writing;

use Illuminate\Support\Facades\Auth;

class SnippetService{


    public function getUsersnippets(){

        return Auth::user()->userSnippets;
    
    
    }
    
public function createUserSnippet($content){


    return Auth::user()->userSnippets()->create([

        'content' => $content,
    ]);
}

public function updateUserSnippet($snippet,$content){


    $snippet->fill(['content' => $content]);

    if ($snippet->isDirty('content')) {

        $snippet->save();
    }


}  


public function deleteUserSnippet($snippet){

    $snippet->delete();

}

}