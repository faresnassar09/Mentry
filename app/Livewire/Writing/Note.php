<?php

namespace App\Livewire\Writing;

use App\Models\Writing\WritingNote;
use App\Service\Web\Logging\LoggingService;
use App\Service\Web\Writing\NoteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;

class Note extends Component
{

    public $books;
    public $selectedBook;
    public $content;
    public $notes;
    public $objectName = 'User note';

    public function mount(){

        $this->books = app(NoteService::class)->getUserBooks();
        
        $this->notes = app(NoteService::class)->getUserNotes();

    }

    public function store(){
        
        $this->validate();

        try {
            

        if(!Auth::check()){

            return to_route('login')->with('failed',__('notifications.should_login'));
        }

        $note = app(NoteService::class)->createUserNote($this->selectedBook,$this->content);

        app(LoggingService::class)->successLogger($this->objectName,'created',[

        'note_id' => $note->id,
        ]);

        $this->selectedBook = '';
        $this->content = '';

        $this->mount();

    return back()->with('success', __('notifications.note_created_successfully'));        

        } catch (\Exception $e) {

            app(LoggingService::class)->failedLogger($this->objectName,'created',[

                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed', __('notifications.note_create_failed'));        


        }
        
    }

    public function delete(WritingNote $note){


        try {

            Gate::authorize('delete',$note);

            app(NoteService::class)->deleteUserNote($note);

            app(LoggingService::class)->successLogger($this->objectName,'deleted',[

                'note_content' => Str::words($note->content,5,'....'),

                ]);

            $this->mount();

            return back()->with('success',__('notifications.note_deleted_successfully'));

      } catch (\Exception $e) {

    app(LoggingService::class)->failedLogger($this->objectName,'created',[

        'note_id' => $note->id,
        'exception_details' => $e->getMessage(),
    ]);

    return back()->with('failed',__('notifications.note_delete_failed'));
        }

    }
    protected function rules()
{
    return[  
        'selectedBook' => ['required','exists:writing_books,id'],
        'content' => ['required','string','min:5','max:500'],
    ];
}

    public function render()
    {
        return view('livewire.writing.note');
    }
}
