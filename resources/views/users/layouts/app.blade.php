<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'موقعي')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class=" min-h-screen flex flex-col">
    @include('users.layouts.status-alert')
<!-- زر فتح السايدبار -->
<div class="lg:hidden fixed top-4 start-4 z-50">
  <button
    id="sidebarToggleBtn"
    type="button"
    class="inline-flex items-center gap-x-2 px-3 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg shadow"
    aria-label="Open sidebar"
  >
    ☰
  </button>
</div>

    <div class="flex flex-1">
    {{-- Sidebar --}}

        @include('users.layouts.sidebar')

    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>

   
   
     

</body>
</html>