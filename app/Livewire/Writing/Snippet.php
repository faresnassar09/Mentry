<?php

namespace App\Livewire\Writing;

use App\Models\Writing\WritingSnippet;
use App\Service\Web\Logging\LoggingService;
use App\Service\Web\Writing\SnippetService;
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
    public $objectName = "User Snippet";

    public function mount()
    {


        $this->snippets = app(SnippetService::class)->getUsersnippets();
    }

    public function store()
    {

        $this->validate();

        try {

            if (!Auth::check()) {

                return back('failed', __('notifications.should_login'));
            }

            $snippet = app(SnippetService::class)->createUserSnippet($this->content);

            $this->content = '';

            $this->mount();

            app(LoggingService::class)->successLogger($this->objectName, 'created', [

                'snippet_id' => $snippet,
            ]);

            return back()->with('success',__('notifications.snippet_created_successfully'));
        } catch (\Exception $e) {

            app(LoggingService::class)->failedLogger($this->objectName, 'createing', [

                'snippet_id' => $snippet,
                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed',__('notifications.snippet_create_failed'));

        }
    }


    public function delete(WritingSnippet $snippet)
    {
        try {

            Gate::authorize('delete', $snippet);

            $snippet->delete();

            app(LoggingService::class)->successLogger($this->objectName, 'deleted', [

                'snippet_id' => $snippet->id,
            ]);

            $this->mount();

            return back()->with('success',__('notifications.snippet_deleted_successfully'));

        } catch (\Exception $e) {

            app(LoggingService::class)->failedLogger($this->objectName, 'deleting', [

                'snippet_content' => Str::words($snippet->content, 5, '....'),
                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed',__('notifications.snippet_delete_failed'));
        }
    }

    protected function rules()
    {
        return [
            'content' => ['required', 'string', 'min:5', 'max:500'],
        ];
    }
    
}
