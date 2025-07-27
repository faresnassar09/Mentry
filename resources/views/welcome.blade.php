<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentry</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<nav class="bg-white shadow-sm py-4 h-20">
    <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-start justify-between"> {{-- ✅ استخدم items-start لرفع المحتويات --}}
        <div class="text-2xl font-bold text-blue-600 mb-2 sm:mb-0 pt-0"> {{-- ✅ إضافة pt لرفع اللوجو --}}
            <a href="{{ url('/') }}" class="flex items-center space-x-2 space-x-reverse">
                <img src="{{ Storage::url('Logo.PNG') }}" alt="Mentry Logo" class="w-16 h-16 object-contain">
                <span class="text-xl font-bold text-gray-800">Mentry</span>
            </a>
        </div>
@if (!auth()->check())
    
        <div class="flex space-x-4 rtl:space-x-reverse pt-1"> {{-- ✅ رفع أزرار الدخول والتسجيل --}}
            <a href="{{ route('login') }}"
               class="text-gray-700 hover:text-blue-600 font-medium transition duration-200">
                تسجيل الدخول
            </a>
            <a href="{{ route('register') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                إنشاء حساب
            </a>
        </div>
         
        @else 
        <div class="flex space-x-4 rtl:space-x-reverse pt-1"> {{-- ✅ رفع أزرار الدخول والتسجيل --}}
            <a href="{{ route('login') }}"
               class="text-gray-700 hover:text-blue-600 font-medium transition duration-200">
                العودة الي الصفحة الرئيسية
            </a>
        </div>

        @endif

    </div>
</nav>


    <main class="max-w-6xl mx-auto mt-12 px-4 text-center">

        <h1 class="text-4xl font-bold text-blue-700 mb-6">مرحبًا بك في  Mentry 📚</h1>
        <p class="text-lg text-gray-600 mb-12">
            منصة تساعدك على التركيز، التلخيص، وتثبيت المعرفة أثناء القراءة والكتابة.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            <div class="bg-white shadow rounded-xl p-6 hover:shadow-md transition">
                <div class="text-3xl mb-3 text-blue-500">📝</div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">تدوين الملاحظات</h3>
                <p class="text-gray-600 text-sm">
                    سجّل أفكارك خلال القراءة، وارجع لها بسهولة في أي وقت.
                </p>
            </div>

            <div class="bg-white shadow rounded-xl p-6 hover:shadow-md transition">
                <div class="text-3xl mb-3 text-green-500">✂️</div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">مقتطفات مركزة</h3>
                <p class="text-gray-600 text-sm">
                    احتفظ بأبرز العبارات التي لامستك، أو لخص بها فكرة بسرعة.
                </p>
            </div>

            <div class="bg-white shadow rounded-xl p-6 hover:shadow-md transition">
                <div class="text-3xl mb-3 text-yellow-500">📖</div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">مكتبةك الخاصة</h3>
                <p class="text-gray-600 text-sm">
                    أنشئ كتبك، حملها، واستعرضها بطريقة منظمة وجذابة.
                </p>
            </div>
        </div>

        <section class="bg-white p-8 rounded-xl shadow mb-20 max-w-4xl mx-auto text-right leading-loose">
            <h2 class="text-2xl font-bold text-blue-700 mb-4">🎯 الهدف من Mentry</h2>
            <p class="text-gray-700 text-md">
                المنصة دي مش مجرد مكتبة عادية، لكنها مساحة شخصية بتنظم أفكارك،
                وتخليك تركز على المعلومة بدل ما تشتتها. الملاحظات، المقتطفات،
                وحتى كتبك اللي بتكتبها بنفسك، كلها بتتجمع في مكان واحد يديك تجربة كتابة وقراءة هادفة وعملية.
            </p>
        </section>

    </main>

    <footer class="py-6 bg-white border-t text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} تم تطويره بكل ❤️ بواسطة فارس نصار
    </footer>

</body>
</html>
