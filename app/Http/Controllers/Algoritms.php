<?php

namespace App\Http\Controllers;

class Algoritms extends Controller
{


public function index(){  

    

    $nums = [];  

    for($i =1; $i<5000001;$i++){


        $nums []=$i;
    }

    $target =5000000 ; 


    $steps = 0;
    $high = count($nums) - 1;

    //when target greater than mid  high will never change

    $low = 0;  

    while($low <= $high){

              $mid  = intdiv($low + $high,2);
                

                

        if($nums[$mid] == $target){

            break;
        }
        
        $steps ++ ;

    if ($nums[$mid] < $target) {  
          

        $low = $mid + 1;


    } else {
        $high = $mid - 1; 

    }


    } 

    dd('steps'.'/'.$steps,'target'.'/'. $target);
}
}
