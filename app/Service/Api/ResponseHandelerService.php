<?php

namespace App\Service\Api;


class ResponseHandelerService {

 
    public function successResponse($message,$data,$code){

        return response()->json(
            [
                'success' => true,
                'message' => $message ,
                'data' => $data,
            ],
           $code
        );

    }

    public function failedResponse($message,$data,$code){

        return response()->json(
            [
                'success' => false,
                'message' => $message ,
                'data' => $data,
            ],
           $code
        );

    }
}