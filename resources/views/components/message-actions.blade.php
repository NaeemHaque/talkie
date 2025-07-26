@props(['response'])

<div class="flex items-center gap-2 mt-2 px-1">
    <button class="p-1.5 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-colors"
            title="Copy response"
            onclick="copyToClipboard({{ json_encode($response) }})">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
        </svg>
    </button>
    <button class="p-1.5 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-colors" title="Regenerate">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
    </button>
</div>