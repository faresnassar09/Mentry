@extends('users.layouts.app')

@section('title', $title)

@section('content')

<section class="container px-4 mx-auto">

    <div class="flex flex-col mt-6">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="relative border border-gray-200 dark:border-gray-700 md:rounded-lg overflow-visible">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 relative">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="py-3.5 px-4 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-x-3">
                                        <span>File name</span>
                                    </div>
                                </th>
                                <th class="px-12 py-3.5 text-sm font-normal text-left text-gray-500 dark:text-gray-400">تاريخ اخر قراء</th>
                                <th class="px-4 py-3.5 text-sm font-normal text-left text-gray-500 dark:text-gray-400">تاريخ التحميل</th>
                                <th class="py-3.5 px-4 text-sm font-normal text-left text-gray-500 dark:text-gray-400">التحكم</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">

                        @foreach ($books as $book)
                            
                            <tr>
                                <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-x-3">
                                        <div class="flex items-center gap-x-2">
                                            <div class="flex items-center justify-center w-8 h-8 text-blue-500 bg-blue-100 rounded-full dark:bg-gray-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h2 class="font-normal text-gray-800 dark:text-white">{{ $book->title .'.'.'pdf'}}</h2>
                                                <p class="text-xs font-normal text-gray-500 dark:text-gray-400">350 KB</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-12 py-4 text-sm font-normal text-gray-700 whitespace-nowrap">{{$book->last_read ?? 'لم تقراءه بعد'}}</td>
                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{$book->created_at->format('Y:m:d')}}</td>
                                <td class="px-4 py-4 text-sm whitespace-nowrap flex gap-2">

                                    <a href="{{route('users.study.books.view',$book->id)}}" class="inline-block px-3 py-1 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">قراء</a>

                                    <a href="{{route('users.study.books.download',$book->id)}}" class="inline-block px-3 py-1 text-sm text-white bg-green-500 rounded hover:bg-green-600">تحميل</a>

                                    <form action="{{route('users.study.books.delete',$book->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                            حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
