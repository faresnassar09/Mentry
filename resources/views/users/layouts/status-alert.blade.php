@if(session('success'))

<div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50">
    <div id="toast-status" class="flex items-center w-full max-w-xs p-4 text-green-700 bg-green-100 border border-green-400 rounded shadow" role="alert">
        <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-200 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 1 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
        </div>

        <div class="ms-3 text-sm font-normal">
            <span class="block sm:inline">{{session('success')}}</span>
        </div>

        <button type="button" class="ms-auto text-green-700 hover:text-green-900 rounded-lg focus:outline-none p-1.5" onclick="this.closest('#toast-status').remove()">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13"/>
            </svg>
        </button>
    </div>
</div>

@elseif (session('failed'))
<div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50">
    <div id="toast-status" class="flex items-center w-full max-w-xs p-4 text-red-700 bg-red-100 border border-red-400 rounded shadow" role="alert">
        <!-- ✅ أيقونة -->
        <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-200 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8.257 3.099c.366-.446.957-.446 1.323 0l6.517 7.945c.33.403.07.956-.442.956H2.345c-.512 0-.772-.553-.442-.956L8.257 3.1zM11 13a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm-1-2a1 1 0 0 0 1-1V8a1 1 0 1 0-2 0v2a1 1 0 0 0 1 1z"/>
            </svg>
        </div>

        <!-- ✅ نص الرسالة -->
        <div class="ms-3 text-sm font-normal">
            <span class="block sm:inline">{{session('failed')}}</span>
        </div>

        <!-- ✅ زر الإغلاق -->
        <button type="button" class="ms-auto text-red-700 hover:text-red-900 rounded-lg focus:outline-none p-1.5" onclick="this.closest('#toast-status').remove()">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13"/>
            </svg>
        </button>
    </div>
</div>
<script>


setTimeout(() => {
        const toast = document.getElementById('toast-status');
        if (toast) {
            toast.remove();
        }
    }, 3000);
</script>
@endif
