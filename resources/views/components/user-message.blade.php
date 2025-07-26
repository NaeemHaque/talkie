@props(['message', 'timestamp', 'filename' => null])

<!-- User Message -->
<div class="flex justify-end animate-slide-up">
    <div class="max-w-3xl">
        <div class="bg-[#5b6df0] text-white rounded-2xl rounded-br-lg px-5 py-3 shadow-lg">
            <p class="text-sm leading-relaxed">{{ $message }}</p>
            @if($filename)
                <div class="mt-2 p-2 bg-white/10 rounded-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-xs">{{ $filename }}</span>
                </div>
            @endif
        </div>
        <div class="flex items-center justify-end gap-3 mt-2 px-1">
            <span class="text-xs text-[#a3a3a3]">{{ $timestamp }}</span>
            <span class="text-xs text-[#a3a3a3]">You</span>
            <div class="w-6 h-6 bg-[#5b6df0] rounded-full flex items-center justify-center">
                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>
</div>