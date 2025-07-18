<?php

namespace App\Http\Controllers\Study;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{

    public function index()
    {
        $title = 'جداول المذاكرة';

        $now = now();

        $allSchedules = Auth::user()->studySchedules()->with('items')->orderBy('created_at', 'desc')->get();

        $currentSchedule = $allSchedules?->where('ends_at','>',now())->first();

        $previousSchedules = $allSchedules?->where('id','!=',$currentSchedule?->id);


        return view('users.study.schedules.index',compact(
            'currentSchedule',
            'previousSchedules',
            'title'
            
       ));
    }


    public function create()
    {

        $title = 'اضافة جدول';


        return view('users.study.schedules.create', compact('title'));
    }
}
