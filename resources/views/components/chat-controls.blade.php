<!-- Chat Controls -->
<div class="flex items-center gap-3">
    @if($conversations->isNotEmpty())
        <form action="{{ route('gemini.new') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="p-2 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-all duration-200" title="New Chat">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>
        </form>

        <form action="{{ route('gemini.clear') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="p-2 text-[#a3a3a3] hover:text-red-400 hover:bg-[#262626] rounded-lg transition-all duration-200" title="Clear Chat"
                    onclick="return confirm('Are you sure you want to clear this conversation?')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </form>
    @endif

    <!-- Theme Toggle -->
    <button onclick="toggleTheme()" class="p-2 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    </button>
</div>
