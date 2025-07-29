<?php

namespace App\Http\Controllers\Api\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\ScheduleRequest;
use App\Http\Resources\Study\ScheduleResource;
use App\Models\Study\StudySchedule;
use App\Service\Api\ResponseHandelerService;
use App\Service\Api\Study\ScheduleService as StudyScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{

    public function __construct(

        public ResponseHandelerService $responseHandelerService,
        public StudyScheduleService $studyScheduleService,
    ) {}


    public function index()
    {

        $schedules = $this->studyScheduleService->getUserStudySchedules();

        return $this->responseHandelerService->successResponse(

            'Study schedules retrieved successfully',
            ScheduleResource::collection($schedules),
            200
        );
    }


    public function store(ScheduleRequest $request)
    {

        if (empty($request->subjects)) {

            return $this->responseHandelerService->failedResponse(

                'Error occurred the schedule subject is empty',
                [],
                500
            );
        }

        try {
            DB::beginTransaction();

            $schedule = $this->studyScheduleService->createStudySchedule();

            $this->studyScheduleService->createScheduleItems($request, $schedule);

            DB::commit();

            Log::channel('userapi')->error('Study schedule created successfully ', [

                'user_id' => $schedule->user_id,
                'schedule_id' => $schedule->id,
            ]);

            $scheduleWithItems =  $schedule->load('items');
            return $this->responseHandelerService->successResponse(

                'Study schedule created successfully',
                new ScheduleResource($scheduleWithItems),
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();


            Log::channel('userapi')->error('Error occurred while saving study schedule', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            return $this->responseHandelerService->failedResponse(

                'Error occurred while saving study schedule',
                [],
                500
            );
        }
    }
}
