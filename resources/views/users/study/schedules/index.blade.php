@extends('users.layouts.app')

@section('title', 'جداول المذاكرة')

@section('content')
<script src="//unpkg.com/alpinejs" defer></script>

<section class="container mx-auto px-4 py-6">

    <div class="mb-6 text-end">
        <a href="{{ route('users.study.schedules.create') }}"
           class="bg-green-500 hover:bg-green-700 text-black text-sm px-4 py-2 rounded shadow transition">
            + إضافة جدول 
        </a>
    </div>

    <div class="space-y-4">

        

    <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-4 max-w-2xl mx-auto"
             x-data="{ open: true }">          

            <div class="flex items-center justify-between cursor-pointer mb-2" @click="open = !open">
  @if ($currentSchedule)
                <div class="flex flex-col gap-1">
                    <h3 class="text-md font-bold text-gray-800">
                        جدول بتاريخ: {{ $currentSchedule?->created_at->format('Y:m:d')}}
                    </h3>
                    <span class="text-sm text-red-600 font-semibold">
                        ينتهي في:{{$currentSchedule?->ends_at->format('h:i') }}
                    </span>
                </div>
                <button class="text-gray-500 hover:text-gray-700 transition">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 15l-7-7-7 7"/>
                    </svg>
                </button>
            </div>
            
            <div x-show="open" x-transition class="mt-4 border-t pt-3 text-sm text-gray-700 space-y-2">
             @endif 
            @if ($currentSchedule?->items)
                
            
            @foreach ($currentSchedule->items as $item )
                    
                
                <div class="flex justify-between items-center">
                    <div>📘 {{$item->task}}</div>
                    <div>{{$item->created_at->diff($item->ends_at)}} </div>
                </div>

@endforeach

@endif
            </div>
        </div>
    </div>

    <div class="mt-10 mb-4 text-center text-sm text-gray-500 font-semibold">
        الجداول السابقة
    </div>

    @foreach ($previousSchedules as $schedule)
        

    <div class="space-y-4">
        <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-4 max-w-2xl mx-auto"
             x-data="{ open: false }">
            <div class="flex items-center justify-between cursor-pointer mb-2" @click="open = !open">
                <div class="flex items-center gap-2">
                    <h3 class="text-md font-bold text-gray-800">
                        جدول بتاريخ: {{ $schedule->created_at->format('Y:m:d') }}
                    </h3>
                    <button class="text-gray-500 hover:text-gray-700 transition">
                        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 15l-7-7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
@foreach ($schedule->items as $item )
    
            <div x-show="open" x-transition class="mt-4 border-t pt-3 text-sm text-gray-700 space-y-2">
                <div class="flex justify-between items-center">
                    <div>📘 {{ $item->task }}</div>
                    <div>{{ $item->ends_at->diff($item->created_at) }}</div>
                </div>
@endforeach


                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
