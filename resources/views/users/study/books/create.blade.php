@extends('users.layouts.app')
@section('title',$title)
@section('content')


<form action="{{route('users.study.books.insert')}}" method="post" class="max-w-sm mx-auto" enctype="multipart/form-data">

  @csrf
  <div class="mb-5">
    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">العنوان
    </label>
    <input type="text"
      name="title"
      id="title"
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  @error('title') border-red-500 @enderror"
      placeholder="كتاب الاحياء"
      required />
  </div>

  @error('title')
  <div class="text-red-600 text-sm">{{ $message }}</div>
  @enderror

  <div class="mb-5">
    <label for="book" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">اضغط لرفع الكتاب</label>
    <input
      type="file"
      name="book"
      id="book"
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  @error('book') border-red-500 @enderror"
      required />
  </div>

  @error('book')
  <div class="text-red-600 text-sm">{{ $message }}</div>
  @enderror

  <div class="flex items-start mb-5">

  </div>
  <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">اضافة</button>
</form>

@endsection