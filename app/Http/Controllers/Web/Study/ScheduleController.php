<?php

namespace App\Http\Controllers\Web\Study;

use App\Http\Controllers\Controller;
use App\Service\Web\Study\ScheduleService as StudyScheduleService;

class ScheduleController extends Controller
{
    public function __construct(

            public StudyScheduleService $studyScheduleService,
    ){}

    public function index()
    {
    
        $schedules = $this->studyScheduleService->getUserStudySchedules();

        $currentSchedule = $schedules?->where('ends_at','>',now())->first();

        $previousSchedules = $schedules?->where('id','!=',$currentSchedule?->id);

        return view('users.study.schedules.index',compact(
            'currentSchedule',
            'previousSchedules',            
       ));
    }

    public function create()
    {

        return view('users.study.schedules.create');
    }
}
