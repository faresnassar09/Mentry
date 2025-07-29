<?php 

namespace App\Service\Api\Study;

use Illuminate\Support\Facades\Auth;

class ScheduleService {

    public function getUserStudySchedules(){

        return Auth::user()->studySchedules()->with('items')->get();


    }

    public function createStudySchedule(){

        return Auth::user()->studySchedules()->create([
            'ends_at' => now()->addMinutes(intval(200)),
        ]);

    }
      
    public function  createScheduleItems($data,$schedule) {

        foreach ($data->subjects as $subject) {
            if (trim($subject['name']) === '' || intval($subject['minutes']) <= 0) continue;

            $schedule->items()->create([
                'task' => $subject['name'],
                'ends_at' => now()->addMinutes(intval($subject['minutes'])),
            ]);
        }
        
    }
   
}