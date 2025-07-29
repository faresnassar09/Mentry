<?php

namespace App\Http\Controllers\Api\Writing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Writing\NoteRequest;
use App\Http\Requests\Writing\NoteUpdateRequest;
use App\Http\Resources\Writing\NoteResource;
use App\Models\Writing\WritingBook;
use App\Models\Writing\WritingNote;
use App\Service\Api\Logging\LoggingService;
use App\Service\Api\ResponseHandelerService;
use App\Service\Api\Writing\NoteService as UserNoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    public $objectName = 'User note';

    public function __construct(

        public UserNoteService $userNoteService,
        public ResponseHandelerService $responseHandelerService,
        public LoggingService $loggingService,

    ) {}

    public function index()
    {

        $notes =  $this->userNoteService->getUserNotes();

        return $this->responseHandelerService->successResponse(

            "{$this->objectName}s retrieved successfully",
            NoteResource::collection($notes),
            200
        );
    }

    public function store(NoteRequest $request)
    {


        if (!Auth::user()->userBooks()->find($request->book_id)) {

            return $this->responseHandelerService->failedResponse(

                'unauthorized action',
                [],
                403
            );
        }

        try {

            $note = $this->userNoteService->createUserNote(

                $request->book_id,
                $request->content

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


            $this->loggingService->failedLogger($this->objectName, 'creating', [

                'exception_details'  => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Error occurred while saving {$this->objectName}",
                [],
                500
            );
        }
    }

    public function show(WritingNote $note)
    {

        Gate::authorize('view', $note);

        return $this->responseHandelerService->successResponse(

            "{$this->objectName} retrieved successfully",
            new NoteResource($note),
            200
        );
    }

    public function update(NoteUpdateRequest $request, WritingNote $note)
    {

        Gate::authorize('update', $note);

        try {

            $this->userNoteService->updateUserNote($note, $request->content);

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

                'note_id' => $note->id,
                'exception_details' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Error occurred while updating {$this->objectName}",
                [],
                500
            );
        }
    }

    public function destroy(WritingNote $note)
    {

        Gate::authorize('delete', $note);

        try {

            $this->userNoteService->deleteUserNote($note);
            $this->loggingService->successLogger($this->objectName, 'deleted', [

                'note_id' => $note->id
            ]);

            return $this->responseHandelerService->successResponse(

                "{$this->objectName} deleted successfully",
                [],
                200
            );
        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'deleting', [

                'exception_details' => $e->getMessage(),
            ]);

            return $this->responseHandelerService->failedResponse(

                "Error occurred while deleting {$this->objectName}",
                [],
                500
            );
        }
    }
}
