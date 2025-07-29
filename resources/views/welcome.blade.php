<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentry</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<nav class="bg-white shadow-sm py-4 h-20">
    <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-start justify-between">
        <div class="text-2xl font-bold text-blue-600 mb-2 sm:mb-0 pt-0">
            <a href="{{ url('/') }}" class="flex items-center space-x-2 space-x-reverse">
                <img src="{{ Storage::url('Logo.PNG') }}" alt="Mentry Logo" class="w-16 h-16 object-contain">
                <span class="text-xl font-bold text-gray-800">Mentry</span>
            </a>
        </div>
@if (!auth()->check())
        <div class="flex space-x-4 rtl:space-x-reverse pt-1">
            <a href="{{ route('login') }}"
               class="text-gray-700 hover:text-blue-600 font-medium transition duration-200">
                {{ __('messages.login_button') }}
            </a>
            <a href="{{ route('register') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                {{ __('messages.create_account_button') }}
            </a>
        </div>
@else
        <div class="flex space-x-4 rtl:space-x-reverse pt-1">
            <a href="{{ route('dashboard') }}" {{-- Assuming a dashboard route for logged-in users --}}
               class="text-gray-700 hover:text-blue-600 font-medium transition duration-200">
                {{ __('messages.back_to_home_button') }}
            </a>
        </div>
@endif

    </div>
</nav>

    <main class="max-w-6xl mx-auto mt-12 px-4 text-center">

        <h1 class="text-4xl font-bold text-blue-700 mb-6">{{ __('messages.welcome_heading', ['app_name' => 'Mentry']) }} 📚</h1>
        <p class="text-lg text-gray-600 mb-12">
            {{ __('messages.platform_description') }}
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            <div class="bg-white shadow rounded-xl p-6 hover:shadow-md transition">
                <div class="text-3xl mb-3 text-blue-500">📝</div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">{{ __('messages.feature_notes_heading') }}</h3>
                <p class="text-gray-600 text-sm">
                    {{ __('messages.feature_notes_description') }}
                </p>
            </div>

            <div class="bg-white shadow rounded-xl p-6 hover:shadow-md transition">
                <div class="text-3xl mb-3 text-green-500">✂️</div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">{{ __('messages.feature_snippets_heading') }}</h3>
                <p class="text-gray-600 text-sm">
                    {{ __('messages.feature_snippets_description') }}
                </p>
            </div>

            <div class="bg-white shadow rounded-xl p-6 hover:shadow-md transition">
                <div class="text-3xl mb-3 text-yellow-500">📖</div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">{{ __('messages.feature_private_library_heading') }}</h3>
                <p class="text-gray-600 text-sm">
                    {{ __('messages.feature_private_library_description') }}
                </p>
            </div>
        </div>

        <section class="bg-white p-8 rounded-xl shadow mb-20 max-w-4xl mx-auto text-right leading-loose">
            <h2 class="text-2xl font-bold text-blue-700 mb-4">🎯 {{ __('messages.mentry_goal_heading') }}</h2>
            <p class="text-gray-700 text-md">
                {{ __('messages.mentry_goal_description') }}
            </p>
        </section>

    </main>

    <footer class="py-6 bg-white border-t text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} {{ __('messages.footer_developer_info', ['developer_name' => 'فارس نصار']) }}
    </footer>

</body>
</html>