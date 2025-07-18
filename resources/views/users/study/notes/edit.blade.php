@extends('users.layouts.app')
@section('title',$title)
@section('content')


<form action="{{route('users.study.notes.update',$note->id)}}" method="POST" class="space-y-6 max-w-xl mx-auto bg-white p-6 rounded-xl shadow">
    @csrf

    <div>
        <label for="title" class="block mb-1 font-medium text-gray-700">العنوان </label>
        <input type="text"
            name="title"
            id="title"
            required
            value="{{$note->title}}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('title') border-red-500 @enderror">
    </div>


    @error('title')
        <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
 
    <div>
        <label for="body" class="block mb-1 font-medium text-gray-700">محتوى الملاحظة</label>
        <textarea
            name="body"
            id="body"
            rows="6"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('body') border-red-500 @enderror">    {{ old('body') }}
                       {{$note->body}}
 </textarea>
            @error('body')
        <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
 
    </div> 

    <div class="text-center">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow">
            تعديل الملاحظة
        </button>
    </div>
</form>


@endsection