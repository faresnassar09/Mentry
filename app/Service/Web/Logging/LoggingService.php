<?php
namespace App\Service\Web\Logging;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class LoggingService{

public $successMessag = 'successfully';
public $failedMessage = 'Unexpected error occurred while';


function successLogger($objectName,$status,array $data){
  
     
    $this->handleMessageAndData($objectName,$status,$data,$this->successMessag);

}


public function failedLogger($objectName,$status,$data){


$this->handleMessageAndData($objectName,$status,$data,$this->failedMessage);



}

private function handleMessageAndData($objectName,$status,$data,$message){

    $data = ['user_id' => Auth::id(),'user_ip' => request()->ip()] + $data;

if ($message == $this->successMessag){

    Log::channel('user')->info($objectName.' ' .$status.' '.$message,$data);


}
else {
    
    Log::channel('user')->error($message.' '.$status.' '.$objectName,$data);

}

}

}