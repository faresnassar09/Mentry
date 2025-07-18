@extends('users.layouts.app')
@section('title', $title)

@section('content')

@livewireStyles()
@livewireScripts()

<livewire:reading.books.search-bar />

<div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @foreach ($books as $book)
            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col h-full transform transition-transform duration-200 hover:scale-105">

                <div class="h-30 overflow-hidden">
                    <img src="{{ Storage::url($book->cover_path) }}"
                         alt="{{ $book->title }}"
                         class="w-full h-50 object-cover">
                </div>

                <div class="p-4 flex flex-col justify-between flex-grow">
                    <div>
                        {{-- ✅ العنوان + التصنيف في نفس السطر --}}
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="text-lg font-bold text-gray-800 truncate">
                                {{ $book->title }}
                            </h2>
                            <span class="text-sm text-gray-500 whitespace-nowrap">
                                التصنيف: <span class="font-medium text-gray-700">{{ $book->category->name ?? 'غير محدد' }}</span>
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit($book->description, 120, '...') }}
                        </p>
                    </div>

                    <div class="flex justify-between text-sm mt-4 gap-2 flex-wrap">
                        <a href="{{ route('reading.books.read', $book->id) }}"
                           class="flex-1 text-center bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200 min-w-[70px]">
                            قراءة
                        </a>
                        <a href="{{ route('reading.books.download', $book->id) }}"
                           class="flex-1 text-center bg-green-500 text-white px-3 py-2 rounded-lg hover:bg-green-600 transition-colors duration-200 min-w-[70px]">
                            تحميل
                        </a>
                    </div>

                </div>

            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $books->links() }}
    </div>

</div>

@endsection
