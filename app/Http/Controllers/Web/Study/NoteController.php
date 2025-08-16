<?php

namespace App\Http\Controllers\Web\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\NoteRequest;
use App\Models\Study\StudyNote;
use App\Service\Web\Logging\LoggingService;
use App\Service\Web\Study\NoteService as StudyNoteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller
{
    public $objectName = 'Study note';

    public function __construct(

        public  StudyNoteService $studyNoteService,
        public LoggingService $loggingService,
        ) {}


    public function index()
    {
        $notes = $this->studyNoteService->getUserStudyNotes();

        return view('users.study.notes.index', compact('notes'));
    }

    public function create()
    {
        $books = Auth::user()->studyBooks;

        return view('users.study.notes.create', compact( 'books'));
    }


    public function store(NoteRequest $request)
    {

        try {

            $book = 
            $request->study_book_id
            === null ? null :
            Auth::user()->studyBooks()->find($request->study_book_id) ;

            $note = $this->studyNoteService->createStudyNote(

                $request->title,
                $request->body,
                $book?->id,
            );

            $this->loggingService->successLogger($this->objectName, 'created', [

                'note_id' => $note->id,
            ]);

            return back()->with('success', __('notifications.note_created_successfully'));

        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'creating', [

                'exception_details' => $e->getMessage(),

            ]);

            return back()->with('failed', __('notifications.note_create_failed'));
        }
    }

    public function edit(StudyNote $note)
    {

        Gate::authorize('edit', $note);

        return view('users.study.notes.edit', compact('note'));
    }

    public function update(StudyNote $note, NoteRequest $request)
    {
        try {

            Gate::authorize('update', $note);
    
                $this->studyNoteService->updateStudyNote($note, $request);
    
                $this->loggingService->successLogger($this->objectName, 'updated', [
    
                    'note_id' => $note->id,
                ]);
    
                return back()->with('success', __('notifications.note_updated_successfully'));

            } catch (\Exception $e) {
    
                $this->loggingService->failedLogger($this->objectName, 'updating', [
    
                    'exception_details' => $e->getMessage(),
                ]);
    
                return back()->with('failed',__('notifications.note_update_failed'));
            }
     
    }

    public function  delete(StudyNote $note)
    {

        try {

            Gate::authorize('delete', $note);

            $this->studyNoteService->deleteStudyNote($note);

            $this->loggingService->successLogger($this->objectName,'deleted',[
                
                'note_title' => $note->title,
            ]);

            return  back()->with('success', __('notifications.note_deleted_successfully'));

        } catch (\Exception $e) {

            $this->loggingService->failedLogger($this->objectName, 'deleting', [

                'note_id' => $note->id,
                'exception_details' => $e->getMessage(),

            ]);

        }

        return back()->with('failed',__('notifications.note_delete_failed'));
    
    }

}