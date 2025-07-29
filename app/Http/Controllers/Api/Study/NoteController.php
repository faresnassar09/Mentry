<?php

namespace App\Http\Controllers\Api\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\NoteRequest;
use App\Http\Resources\Study\NoteResource;
use App\Models\Study\StudyNote;
use App\Service\Api\Logging\LoggingService;
use App\Service\Api\ResponseHandelerService;
use App\Service\Api\Study\NoteService as StudyNoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{

    public $objectName = 'Study note';

    public function __construct(

        public ResponseHandelerService $responseHandelerService,
        public  StudyNoteService $studyNoteService,
        public LoggingService $loggingService,

    ) {}

    public function index()
    {

        $notes = $this->studyNoteService->getUserStudyNotes();

        return $this->responseHandelerService->successResponse(

            "{$this->objectName} retrieved successfully",
            NoteResource::collection($notes),
            200
        );
    }

    public function store(NoteRequest $request)
    {

        try {

            $note = $this->studyNoteService->createStudyNote(

                $request->title,
                $request->body,
                $request->studyBookId
            );

            $this->loggingService->successLogger($this->objectName, 'created', [

                'note_id' => $note->id,
            ]);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} created successfully",
                new NoteResource($note),
                201
            );
        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'deleting', [

                'exception_details' => $e->getMessage(),

            ]);

            return $this->responseHandelerService->failedResponse(

                "Unexpected occurred while saving {$this->objectName}",
                [],
                500
            );
        }
    }


    public function show(StudyNote $note)
    {

        Gate::authorize('view', $note);

        return $this->responseHandelerService->successResponse(

            "{$this->objectName} retrieved successfully",
            new NoteResource($note),
            200
        );
    }


    public function update(StudyNote $note, NoteRequest $request)
    {

        Gate::authorize('update', $note);

        try {


            $this->studyNoteService->updateStudyNote($note, $request);

            $this->loggingService->successLogger($this->objectName, 'updated', [

                'note_id' => $note->id,

            ]);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} updated successfully",
                new NoteResource($note),
                200
            );
        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'updating', [

                'exception_details' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Unexpected error occurred while updating {$this->objectName}",
                [],
                500
            );
        }
    }

    public function destroy(StudyNote $note)
    {

        Gate::authorize('delete', $note);

        try {

            $this->studyNoteService->deleteStudyNote($note);

            $this->loggingService->successLogger($this->objectName,'deleting',[
                
                'note_title' => $note->title,
            ]);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} deleted successfully",
                [],
                200
            );

        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'deleting', [

                'note_id' => $note->id,
                'exception_details' => $e->getMessage(),

            ]);

            return $this->responseHandelerService->failedResponse(

                "Unexpected error occurred while deleting {$this->objectName}",
                [],
                500
            );
        }
    }
}
