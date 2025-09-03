<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', config('app.name', 'MyShop'))</title>

    {{-- Tailwind via CDN for zero-build drop-in --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- If your app already uses Vite, you can uncomment this: --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    @stack('head')
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    @include('partials.navbar')

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <main class="container mx-auto px-4 py-6 flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
    @stack('scripts')
</body>
</html>
