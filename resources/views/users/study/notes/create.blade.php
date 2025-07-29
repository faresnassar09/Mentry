@extends('users.layouts.app')
@section('title', __('messages.add_note_page_title'))
@section('content')

<form action="{{route('users.study.notes.insert')}}" method="POST" class="space-y-6 max-w-xl mx-auto bg-white p-6 rounded-xl shadow">
    @csrf

    <div>
        <label for="title" class="block mb-1 font-medium text-gray-700">{{ __('messages.note_title_label') }}</label>
        <input type="text"
            name="title"
            id="title"
            required
            value="{{ old('title') }}"
            placeholder="{{ __('messages.note_title_placeholder') }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('title') border-red-500 @enderror">
    </div>

    @error('title')
        <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror

    <div>
        <label for="body" class="block mb-1 font-medium text-gray-700">{{ __('messages.note_content_label') }}</label>
        <textarea
            name="body"
            id="body"
            rows="6"
            required
            placeholder="{{ __('messages.note_content_placeholder') }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('body') border-red-500 @enderror">{{ old('body') }}</textarea>
        @error('body')
        <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="study_book_id" class="block mb-1 font-medium text-gray-700">{{ __('messages.link_book_label') }}</label>
        <select name="study_book_id" id="study_book_id"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300">
            <option value="">{{ __('messages.without_book_option') }}</option>
            @foreach ($books as $book)
            <option value="{{ $book->id }}">{{ $book->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="text-center">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow">
            {{ __('messages.save_note_button') }}
        </button>
    </div>
</form>

@endsection