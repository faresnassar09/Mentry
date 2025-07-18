@extends('users.layouts.app')
@section('title',$title)
@section('content')



<form action="{{route('users.study.materials.insert')}}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6 bg-white rounded-xl shadow-md max-w-lg mx-auto">
    @csrf

    <h2 class="text-sm font-semibold text-gray-800 text-center"> القسم ده معمول علشان يساعدك تفصل بين الكتب و ملخصاتك و ملازمك</h2>

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان </label>
        <input
            type="text"
            name="title"
            id="title"
            autofocus
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('title') border-red-500 @enderror">

        @error('title')
        <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror

    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2"> ملزمة و لا ملخص ؟ في العادة الملخص مثلا سكرين شوت او حاجات بسيطة </label>
        <div class="flex items-center gap-6">
            <label class="inline-flex items-center">
                <input type="radio" name="type" value="1" checked  required class="text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700">ملزمة</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="type" value="2" required class="text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700">ملخص</span>
            </label>
        </div>
    </div>

    <div>
        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">اختر الملف</label>
        <input
            type="file"
            name="file"
            id="file"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('file') border-red-500 @enderror">

        @error('file')
        <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
    </div>

    <div class="text-center">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow">
            حفظ
        </button>
    </div>
</form>



@endsection