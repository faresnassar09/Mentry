<?php

namespace App\Service;

use \Mpdf\HTMLParserMode;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mpdf\Mpdf;

class FileServices{


    public function checkFileExists($path){

$filePath = Storage::exists($path);


    if(!$filePath){

return false;

        }else{

            return true;
        }


    }

public function uploadFile($folder,$file){

    $fileName = Str::uuid().$file->getClientOriginalName();

    $filePath = $file->storeAs($folder,$fileName,'public');

    return $filePath;
}


public function download($path,$name){

    return Storage::download($path,$name);

}


public function delete($path){


    if(!$this->checkFileExists($path)){

        return false;

    }

    Storage::delete($path);

    return true;

} 


public function storeGeneratedFile($folder, $title, $content){

  
    $filePath =$folder.'/'.Str::uuid().$title.'.txt';

     
    $status = Storage::put($filePath,$content);

    return ['status'=>$status,'path'=>$filePath];

}  

public function getFileContent($path){

    return Storage::get($path);

}

public function updateExistFileContent($path,$content,$id){

      
     try {
        

         
        Log::channel('user')->info('user book content updated successfully',[

            'user_id' => Auth::id(),
            'book_id' => $id,
        ]);
Storage::put($path,$content);

        return true;
    
     } catch (\Exception $e) {
  
        Log::channel('user')->error('error occurred while updating user book content',[

            'user_id' => Auth::id(),
            'book_id' => $id,
            'exception_details' => $e->getMessage(),
        ]);

        return false;

    }


} 

public function generatePdfFile($path, $title)
{
    $file = Storage::get($path);

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'default_font' => 'cairo'
    ]);

    $mpdf->WriteHTML($file, \Mpdf\HTMLParserMode::HTML_BODY);

    return response()->streamDownload(function () use ($mpdf) {
        echo $mpdf->Output('', 'S');
    }, $title.'.pdf', [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="' . $title . '.pdf"',
    ]);
}


 public function deleteGeneralFile($book){

try {
    if(!$this->checkFileExists($book->path)){ throw new \Exception('File not found');}

        Storage::delete($book->path);

        Log::channel('user')->info('user book deleted successfully',[

            'user_id' => $book->user_id,
            'book_title' => $book->title,
        ]);
                return true;
            }
        
catch (\Exception $e) {

    Log::channel('user')->error('error occurred while deleting user book from the storage',[
        
        'user_id' => $book->user_id,
        'book_id' => $book->id,
        'exception_details' => $e->getMessage(),
    
    ]);
}

return false;

 }
}    