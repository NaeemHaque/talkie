<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Talkie - Modern Chat')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans bg-[#0f0f0f] text-[#e5e5e5]">
    <!-- Mobile Sidebar Toggle -->
    <div class="lg:hidden fixed top-4 left-4 z-500">
        <button id="sidebar-toggle" class="p-2 bg-[#1a1a1a] border border-[#333333] rounded-lg text-[#e5e5e5] hover:bg-[#262626] transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>

    <div class="flex">
       <!-- Sidebar -->
    <div id="sidebar" class="fixed left-0 top-0 h-full z-50 lg:relative lg:z-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <x-chat-sidebar :chats="$chats ?? collect()" :currentChatId="$chat->id ?? null" />
    </div>

    <!-- Main Content -->
    <div class="min-h-screen flex flex-col w-full">
        <x-header :conversations="$conversations ?? collect()" />

        <main class="flex-1 mx-auto px-6 py-12 min-h-100vh flex flex-col">
            @yield('content')
        </main>
    </div>
    </div>

    @include('components.scripts')
    @stack('scripts')

    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        // Close sidebar when clicking overlay
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>
</html>
