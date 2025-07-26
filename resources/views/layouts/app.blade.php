<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'OrbitAI - Modern Chat')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans bg-[#0f0f0f] text-[#e5e5e5]">
    <x-header :conversations="$conversations ?? collect()" />

    <main class="max-w-5xl mx-auto px-6 py-8 min-h-[calc(100vh-140px)] flex flex-col">
        @yield('content')
    </main>

    @include('components.scripts')
    @stack('scripts')
</body>
</html>
