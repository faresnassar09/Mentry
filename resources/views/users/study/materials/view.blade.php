@extends('users.layouts.app')

@section('title', __('messages.view_material_page_title'))

@section('content')
    <section class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-semibold mb-4">{{ $material->title }}</h1>

        <div class="w-full h-[100vh] border rounded overflow-hidden shadow-lg">
            <iframe
                src="{{ asset('pdfjs/web/viewer.html') }}?file={{ urlencode(asset('storage/' . $material->path)) }}"
                width="100%"
                height="700px"
                style="border: none;">
            </iframe>
        </div>
    </section>
@endsection