<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- إضافة Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- إضافة Flag Icons CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.15.0/css/flag-icons.min.css"/>
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

        <div class="flex items-center space-x-4 rtl:space-x-reverse pt-1">
            {{-- Language Dropdown --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" type="button" class="inline-flex items-center gap-x-1 text-sm font-medium text-gray-700 hover:text-blue-600 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md py-2 px-3">
                    <span class="fi fi-{{ app()->getLocale() === 'ar' ? 'sa' : 'us' }} rounded-full mr-2"></span> {{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}
                    <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-10 mt-2 w-32 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <a href="{{ route('language.switch','ar') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-0">
                            <span class="fi fi-sa rounded-full mr-2"></span> العربية
                        </a>
                        <a href="{{ route('language.switch','en') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-1">
                            <span class="fi fi-us rounded-full mr-2"></span> English
                        </a>
                    </div>
                </div>
            </div>

            {{-- Auth Links --}}
            @if (!auth()->check())
                <a href="{{ route('login') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium transition duration-200">
                    {{ __('messages.login_button') }}
                </a>
                <a href="{{ route('register') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                    {{ __('messages.create_account_button') }}
                </a>
            @else
                <a href="{{ route('dashboard') }}" {{-- Assuming a dashboard route for logged-in users --}}
                   class="text-gray-700 hover:text-blue-600 font-medium transition duration-200">
                    {{ __('messages.back_to_home_button') }}
                </a>
            @endif
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto mt-12 px-4 text-center">
    {{-- Rest of your main content remains unchanged --}}
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