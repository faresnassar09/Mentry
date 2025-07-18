<?php

namespace App\Livewire\Writing;

use App\Models\Writing\WritingNote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class Note extends Component
{

    public $books;
    public $selectedBook;
    public $content;
    public $notes;

    public function mount(){

        $this->books = Auth::user()->userBooks()->select('id','title')->get();

        $this->notes = Auth::user()->userNotes()->with('writingBook:id,title')
        ->orderBy('created_at','desc')
        ->get() ?? null;

        // dd($this->notes);
    }

    public function store(){
        
        $this->validate();

if(!Auth::check()){

    return back('failed','قم بتسجيل الدخول ');
}

$status = $this->insert();

if(!$status){

    $this->selectedBook = '';$this->content = '';

    return back()->with('failed','حدثت مشكلة اثناء حفظ الملاحظة');
 
}

$this->selectedBook = '';$this->content = '';
$this->mount();

    return back()->with('success', 'تم إضافة الملاحظة بنجاح');

    }

    public function delete(WritingNote $note){

        Gate::authorize('delete',$note);

        try {

            $note->delete();

            Log::channel('user')->info('user note deleted successfully',[

                'user_id' => $note->user_id,
                'note_id' => $note->id,
            ]);

            $this->mount();

            return back()->with('success','تم حذف الملاحظة بنجاح');

      } catch (\Exception $e) {

    Log::channel('user')->error('error occurred while deleting user note',[

        'user_id' => $note->user_id,
        'note_content' => Str::words($note->content,5,'....'),
        'exception_details' => $e->getMessage(),

    ]);

    return back()->with('failed','حدث خطاء اثناء حذف الملاحظة');
        }

    }

public function insert(){

try {

    $note = Auth::user()->userNotes()->create([

        'writing_book_id' => $this->selectedBook,
        'content' => $this->content,
        
    ]);

    Log::channel('user')->info('user note created successfully',[

        'user_id' => $note->user_id,
        'note_id' => $note->id,

    ]);

    return true;

} catch (\Exception $e) {

    Log::channel('user')->error('error occurred while saving user note',[

        'user_id' => Auth::id(),
        'exception_details' => $e->getMessage(),
    ]);

    return false;

}


}
    protected function rules()
{
    return[  
        'selectedBook' => ['required','exists:writing_books,id'],
        'content' => ['required','string','min:5','max:500'],
    ];
}

protected function messages()
{
    return [
        'selectedBook.required' => 'يجب اختيار كتاب',
        'selectedBook.exists' => 'الكتاب المحدد غير موجود.',
        'content.required' => 'لا يمكن ترك الملاحظة فارغة.',
        'content.min' => 'الملاحظة يجب أن تكون على الأقل :min أحرف.',
        'content.max' => 'الملاحظة لا يجب أن تتجاوز :max حرفًا.',
    ];
}

    public function render()
    {
        return view('livewire.writing.note');
    }
}
    