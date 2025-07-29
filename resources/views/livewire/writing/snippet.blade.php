<div class="max-w-3xl mx-auto px-4">

    @include('users.layouts.status-alert')

    <form wire:submit="store()" class="bg-white p-4 rounded-xl shadow mt-0 mb-8 space-y-4">
        <h2 class="text-xl font-bold text-gray-800">✂️ {{ __('messages.add_snippet_heading') }}</h2>

        <div>
            <textarea
                wire:model="content"
                rows="3"
                placeholder="{{ __('messages.snippet_placeholder') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500"
            ></textarea>
            @error('content')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            {{ __('messages.add_button') }}
        </button>
    </form>

    @isset($snippets)
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">📌 {{ __('messages.my_snippets_heading') }}</h3>

            @forelse($snippets as $snippet)
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm relative">
                    <a href="#" wire:click="delete({{$snippet->id}})" class="absolute top-2 right-3 text-red-800 text-xl">{{ __('messages.delete_snippet_button') }} ✂️</a>
                    <p class="text-gray-800 whitespace-pre-wrap break-words leading-relaxed">
                        {{ $snippet->content }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">{{ __('messages.no_snippets_yet') }}</p>
            @endforelse
        </div>
    @endisset

</div>