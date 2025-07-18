@extends('users.layouts.app')

@section('title', $title)

@section('content')

<script src="//unpkg.com/alpinejs" defer></script>

<section class="container mx-auto px-4 py-6">

@foreach ( $notes as $note )
    
    <div 
        class="bg-white shadow-sm rounded-lg p-6 mb-6 border text-sm max-w-3xl mx-auto min-h-[240px]" 
        x-data="{ expanded: false }"
    >


    
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <h3 class="font-semibold text-blue-700 text-lg">
                    {{ $note->title .' '}}
                    
                    @isset($note->studyBook)
                        {{ '('.'كتاب'.' ' . $note->studyBook->title.')' }}
                    @endisset

                      
                </h3>

                <button @click="expanded = !expanded" class="text-gray-500 hover:text-blue-600 transition">
                    <svg x-show="!expanded" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg x-show="expanded" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 15l-7-7-7 7" />
                    </svg>
                </button>
            </div>

            <div class="flex gap-2">
                <a href="{{route('users.study.notes.edit',$note->id)}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm">
                    تعديل
                </a>  
                <form action="{{route('users.study.notes.delete',$note->id)}}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الملاحظة؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded text-sm">
                    حذف
                    </button>
                </form>
            </div>
        </div>

        {{-- محتوى الملاحظة --}}
        <p class="text-gray-700 leading-relaxed text-base">
            <span x-show="!expanded">
                {{ \Illuminate\Support\Str::words($note->body, 10, '...') }}
            </span>
            <span x-show="expanded">
                {{ $note->body }}
            </span>
        </p>
    </div>
    @endforeach

</section>

@endsection
