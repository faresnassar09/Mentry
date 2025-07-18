@extends('users.layouts.app')
@section('title', $title)

@section('content')

<form id="writing-form" action="{{ route('users.writing.books.store') }}" method="POST">
    @csrf

    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان الكتاب</label>
        <input type="text" name="title" id="title"
            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            placeholder="اكتب عنوان الكتاب هنا..." required>
    </div>

    <div id="editor" class="bg-white p-4 border rounded-md" style="min-height: 60vh;"></div>

    <input type="hidden" name="content" id="content">

    <button type="submit"
        class="mt-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-6 rounded transition duration-200">
        حفظ المحتوى
    </button>
</form>

<!-- Quill CDN -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<style>
    .ql-editor {
        direction: rtl;
        text-align: right;
        white-space: normal !important;
        word-break: break-word !important;
        font-family: "Tahoma", sans-serif;
        min-height: 60vh;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'ابدأ الكتابة هنا...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        const form = document.getElementById('writing-form');
        form.addEventListener('submit', function (event) {
            const html = quill.root.innerHTML.trim();

            if (!html || html === '<p><br></p>') {
                alert('المحتوى لا يمكن أن يكون فارغًا');
                event.preventDefault();
                return;
            }

            document.getElementById('content').value = html;
        });
    });
</script>

@endsection
