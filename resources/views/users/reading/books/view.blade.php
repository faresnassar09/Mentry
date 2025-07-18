@extends('users.layouts.app')

@section('title', $title)

@section('content')
    <script src="//unpkg.com/alpinejs" defer></script>

    <section class="container mx-auto px-4 py-6" x-data="{ showDetails: false }">

        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <button 
                    class="flex items-center gap-2 text-2xl font-semibold text-gray-800 focus:outline-none"
                    @click="showDetails = !showDetails"
                >
                    {{ $book->title }}
                    <svg 
                        :class="showDetails ? 'rotate-180' : ''" 
                        class="w-5 h-5 text-gray-600 transition-transform duration-300 transform"
                        fill="none" 
                        stroke="currentColor" 
                        stroke-width="2" 
                        viewBox="0 0 24 24"
                    > 
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        اضغط علي السهم لرؤية الوصف و المولف
                    </svg>
                </button>
            </div>

            <a 
                href="{{route('reading.books.download',$book->id)}}" 
                download 
                class="ml-4 bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition"
            >
                تحميل الكتاب
            </a>
        </div>

        <div x-show="showDetails" x-transition class="mb-6 text-gray-700">
            <p class="mb-2"><span class="font-semibold">الوصف:</span> {{ $book->description }}</p>
            <p><span class="font-semibold">المؤلف:</span> {{ $book->author }}</p>
        </div>

        <div class="w-full h-[100vh] border rounded overflow-hidden shadow-lg">
            <iframe
                src="{{ $fileUrl }}"
                class="w-full h-full"
                frameborder="0"
            >
                هذا المتصفح لا يدعم عرض ملفات PDF.
            </iframe>
        </div>

    </section>
@endsection
