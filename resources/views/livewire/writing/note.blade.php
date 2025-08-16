<div class="max-w-2xl mx-auto px-4">

    @include('users.layouts.status-alert')

    <form wire:submit="store()" class="bg-white p-4 rounded-xl shadow mb-6 space-y-3">
        <h2 class="text-lg font-bold text-gray-800">📝 {{ __('messages.add_note_heading') }}</h2>

        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">{{ __('messages.choose_book_label') }}</label>
            <select wire:model="selectedBook" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                <option value="">-- {{ __('messages.select_book_option') }} --</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
            @error('selectedBook') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">{{ __('messages.note_label') }}</label>
            <textarea wire:model="content" rows="2" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500 resize-none"></textarea>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">{{ __('messages.add_button') }}</button>
    </form>

    @isset($notes)
    <div class="bg-white p-6 rounded-xl shadow space-y-4 mt-10">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">📚 {{ __('messages.my_notes_heading') }}</h3>

        @forelse($notes as $note)
            <div class="border-b pb-4 relative">
                <button wire:click="delete({{$note->id}})" class="absolute top-0 right-0 text-red-500 text-sm hover:underline">{{ __('messages.delete_button') }}</button>
                <div class="text-sm text-gray-500 mb-1 pr-14">📖 {{ $note?->writingBook?->title }}</div>
                <div class="text-gray-800 whitespace-pre-wrap break-words pr-14">
                    {{ $note?->content }}
                </div>
            </div>
        @empty
            <p class="text-gray-500">{{ __('messages.no_notes_yet') }}</p>
        @endforelse
    </div>
    @endisset

</div>