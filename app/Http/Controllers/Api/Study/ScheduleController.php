<?php

namespace App\Http\Controllers\Api\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\ScheduleRequest;
use App\Http\Resources\Study\ScheduleResource;
use App\Models\Study\StudySchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $schedules = Auth::user()->studySchedules()->with('items')->get();

        return response()->json(
            [

                'success' => true,
                'message' => 'study schedules retrieved successfully',
                'data' => ScheduleResource::collection($schedules),
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleRequest $request)
    {


        if (empty($request->subjects)) {

            return response()->json([
                'success' => true,
                'message' => 'error occurred the schedule subject is empty',
                'data' => [],

            ]);
        }

        try {
            DB::beginTransaction();

            $schedule = Auth::user()->studySchedules()->create([
                'ends_at' => now()->addMinutes(intval(200)),
            ]);



            foreach ($request->subjects as $subject) {
                if (trim($subject['name']) === '' || intval($subject['minutes']) <= 0) continue;

                $schedule->items()->create([
                    'task' => $subject['name'],
                    'ends_at' => now()->addMinutes(intval($subject['minutes'])),
                ]);
            }

            DB::commit();

            Log::channel('userapi')->error('study schedule created successfully ', [

                'user_id' => $schedule->user_id,
                'schedule_id' => $schedule->id,
            ]);
            return response()->json([

                'success' => true,
                'message' => 'study schedule created successfully',
                'data' =>  $schedule->with('items')->get(),

            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('userapi')->error('error occurred while saving study schedule', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            return response()->json([

                'success' => false,
                'message' => 'error occurred while saving study schedule',
                'data' => [],
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StudySchedule $schedule) {


    }



    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


    }
}
