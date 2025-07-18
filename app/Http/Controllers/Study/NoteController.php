<?php

namespace App\Http\Controllers\Study;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\Note;
use App\Models\Study\StudyNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use PgSql\Lob;

class NoteController extends Controller
{


    public function index()
    {

        $title = 'الملاحظات';
        $notes = Auth::user()->studyNotes()->with('studyBook:id,title')->get();

        return view('users.study.notes.index', compact('title', 'notes'));
    }

    public function create()
    {

        $title = 'اضافة ملاحظة';
        $books = Auth::user()->studyBooks;

        return view('users.study.notes.create', compact('title', 'books'));
    }


    public function store(Note $request)
    {


        if ($request->study_book_id != null && !Auth::user()->studyBooks()->find($request->study_book_id)) {

            Log::channel('user')->error('error occurred while saving the study note', [

                'user_id' => Auth::user()->id,
                'error_details' => 'the chosen study book not found',

            ]);

            return back()->with('failed', 'لم يتم العثور علي الكتاب المحدد');
        }

        try {

            $note =  Auth::user()->studyNotes()->create([

                'title' => $request->title,
                'body' => $request->body,
                'study_book_id' => $request->study_book_id,
            ]);


            Log::channel('user')->info('study note created successfully', [

                'user_id' => $note->user_id,
                'note_id' => $note->id,
                'note_title' => $note->title,
            ]);

            return back()->with('success', 'تم تسجيل الملاحظة بنجاح');
        } catch (\Exception $e) {


            Log::channel('user')->error('error occurred while saving study note', [

                'user_id' => Auth::user()->id,
                'exception_message' => $e->getMessage(),
            ]);

            return back()->with('failed', 'حدث خطاء اثناء الحفظ');
        }
    }

    public function edit(StudyNote $note)
    {

        Gate::authorize('edit', $note);

        $title = 'تعديل ملاحظة';

        return view('users.study.notes.edit', compact('note', 'title'));
    }


    public function update(StudyNote $note, Note $request)
    {

        Gate::authorize('update', $note);
        try {

            $noteUpdate = $note->update($request->validated());


            Log::channel('user')->info('study note updated successfully', [

                'user_id' => $note->user_id,
                'note_id' => $request->id,
                'note_title' => $request->title,

            ]);

            return back()->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {

            Log::channel('user')->error('error occurred while updating study note', [

                'user_id' => Auth::id(),
                'exception_detals' => $e->getMessage(),

            ]);

            return back()->with('failed', 'حدث خطاء اثناء التعديل');
        }
    }

    public function  delete(StudyNote $note)
    {


        Gate::authorize('delete', $note);

        $note->delete();

        Log::channel('user')->info('study note deleted successfully',[

            'user_id' => $note->user_id,
            'note_title' => $note->title,
            'note_body' => $note->body,
        ]);

        return  back()->with('success', 'تم الحذف بنجاح');
    }
}
