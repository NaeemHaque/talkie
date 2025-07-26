<!-- Header -->
<header class="bg-[#1a1a1a] border-b border-[#333333] sticky top-0 z-50 backdrop-blur-sm">
    <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
        <x-logo />
        <x-chat-controls :conversations="$conversations" />
    </div>
</header>
