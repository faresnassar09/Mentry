@extends('users.layouts.app')
@section('title', __('messages.my_books_page_title'))

@section('content')
<section class="max-w-6xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-right">{{ __('messages.my_books_heading') }}</h2>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="text-left text-gray-700 text-sm">
                    <th class="px-4 py-3">{{ __('messages.table_title_header') }}</th>
                    <th class="px-4 py-3">{{ __('messages.table_date_added_header') }}</th>
                    <th class="px-4 py-3">{{ __('messages.table_last_modified_header') }}</th>
                    <th class="px-4 py-3 text-center">{{ __('messages.table_actions_header') }}</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 text-sm text-gray-800">
                @foreach ($books as $book)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $book->title }}</td>
                        <td class="px-4 py-3 font-medium">{{ $book->created_at->format('Y:m') }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($book->updated_at)->diffForHumans() }}</td>
                        <td class="px-4 py-3 flex justify-center gap-2 flex-wrap">

                            <a href="{{route('users.writing.books.edit',$book->id)}}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-xs font-semibold">
                                {{ __('messages.continue_writing_button') }}
                            </a>

                            <a href="{{route('users.writing.books.download',$book->id)}}"
                               class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-xs font-semibold">
                                {{ __('messages.download_button') }}
                            </a>

                            <form action="{{ route('users.writing.books.delete',$book->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.delete_book_confirmation') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs font-semibold">
                                    {{ __('messages.delete_button') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection