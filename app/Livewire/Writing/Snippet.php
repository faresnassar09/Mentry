<?php

namespace App\Livewire\Writing;

use App\Models\Writing\WritingSnippet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class Snippet extends Component
{
    public function render()
    {
        return view('livewire.writing.snippet');
    }

    public $content;
    public $snippets;

    public function mount(){


        $this->snippets = Auth::user()->userSnippets()
        ->orderBy('created_at','desc')
        ->get();

        // dd($this->snippets);
    }

    public function store(){
        

        $this->validate();

if(!Auth::check()){

    return back('failed','قم بتسجيل الدخول ');
}

$status = $this->insert();



if(!$status){

$this->content = '';

    return back()->with('failed','حدثت مشكلة اثناء حفظ المقتطف');
 
}

$this->content = '';

$this->mount();

    return back()->with('success', 'تم إضافة المقتطف بنجاح');

    }

    public function delete(WritingSnippet $snippet){


        Gate::authorize('delete',$snippet);

        try {

            $snippet->delete();

            Log::channel('user')->info('user snippet deleted successfully',[

                'user_id' => $snippet->user_id,
                'snippet_id' => $snippet->id,
            ]);

            $this->mount();

            return back()->with('success','تم حذف المقتطف بنجاح');

      } catch (\Exception $e) {

    Log::channel('user')->error('error occurred while deleting user snippet',[

        'user_id' => $snippet->user_id,
        'snippet_content' => Str::words($snippet->content,5,'....'),
        'exception_details' => $e->getMessage(),

    ]);

    return back()->with('failed','حدث خطاء اثناء حذف المقتطف');
        }

    }

public function insert(){

try {

    $snippet = Auth::user()->userSnippets()->create([

        'content' => $this->content,
        
    ]);

    Log::channel('user')->info('user snippet created successfully',[

        'user_id' => $snippet->user_id,
        'snippet_id' => $snippet->id,

    ]);

    return true;

} catch (\Exception $e) {

    Log::channel('user')->error('error occurred while saving user snippet',[

        'user_id' => Auth::id(),
        'exception_details' => $e->getMessage(),
    ]);

    return false;

}


}
    protected function rules()
{
    return[  
        'content' => ['required','string','min:5','max:500'],
    ];
}

protected function messages()
{
    return [
        'content.required' => 'لا يمكن ترك المحتوي فارغ.',
        'content.min' => 'المحتوي  يجب أن يكون على الأقل :min أحرف.',
        'content.max' => 'المحتوي لا يجب أن تتجاوز :max حرفًا.',
    ];
}
}
