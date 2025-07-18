@extends('users.layouts.app')

@section('title', $title)

@section('content')
    <section class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-semibold mb-4">{{ $material->title }}</h1>

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
