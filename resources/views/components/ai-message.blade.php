@props(['response', 'timestamp', 'loading' => false])

<!-- AI Response -->
<div class="flex justify-start animate-slide-up">
    <div class="max-w-3xl">
        <div class="flex items-center gap-3 mb-2 px-1">
            <div class="w-6 h-6 bg-[#6366f1] rounded-full flex items-center justify-center {{ $loading ? 'animate-pulse' : '' }}">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <span class="text-xs text-[#a3a3a3]">Talkie</span>
            @if(!$loading)
                <span class="text-xs text-[#a3a3a3]">{{ $timestamp }}</span>
            @endif
        </div>
        <div class="bg-[#1a1a1a] border border-[#333333] rounded-2xl rounded-bl-lg px-5 py-3 shadow-lg">
            @if($loading)
                <div class="flex items-center gap-2 text-[#a3a3a3]">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-[#5b6df0]"></div>
                    <span class="text-sm">Thinking...</span>
                </div>
            @else
                <div class="prose prose-sm dark:prose-invert max-w-none text-[#e5e5e5]">
                    {!! nl2br(e($response)) !!}
                </div>
            @endif
        </div>
        @if(!$loading)
            <x-message-actions :response="$response" />
        @endif
    </div>
</div>