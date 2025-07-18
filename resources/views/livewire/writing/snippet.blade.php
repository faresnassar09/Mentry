<div class="max-w-3xl mx-auto px-4">

    {{-- ✅ تصحيح: تضمين التوست الصحيح --}}
    @include('users.layouts.status-alert')

    <form wire:submit="store()" class="bg-white p-4 rounded-xl shadow mt-0 mb-8 space-y-4">
        <h2 class="text-xl font-bold text-gray-800">✂️ أضف مقتطف</h2>

        <div>
            <textarea
                wire:model="content"
                rows="3"
                placeholder="اكتب المقتطف هنا..."
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500"
            ></textarea>
            @error('content') 
                <span class="text-red-500 text-sm">{{ $message }}</span> 
            @enderror
        </div>

        <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            إضافة
        </button>
    </form>

    @isset($snippets)
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">📌 مقتطفاتي</h3>

            @forelse($snippets as $snippet)
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm relative">
                    <a href="#" wire:click="delete({{$snippet->id}})" class="absolute top-2 right-3 text-red-800 text-xl">حذف ✂️</a>
                    <p class="text-gray-800 whitespace-pre-wrap break-words leading-relaxed">
                        {{ $snippet->content }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">لا توجد مقتطفات حتى الآن.</p>
            @endforelse
        </div>
    @endisset

</div>
