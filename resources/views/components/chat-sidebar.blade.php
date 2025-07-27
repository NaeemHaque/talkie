@props(['chats', 'currentChatId' => null])

<!-- Chat Sidebar -->
<div class="w-80 bg-[#1a1a1a] border-r border-[#333333] h-screen overflow-y-auto">
    <div class="p-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-[#e5e5e5]">Chat History</h2>
            <form action="{{ route('gemini.new') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="p-2 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-all duration-200" title="New Chat">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Chat List -->
        <div class="space-y-2">
            @forelse($chats as $chat)
                <div class="group relative">
                    <!-- Chat Item -->
                    <a href="{{ route('gemini.load', $chat->id) }}" 
                       class="block p-3 rounded-lg transition-all duration-200 {{ $currentChatId == $chat->id ? 'bg-[#5b6df0] text-white' : 'hover:bg-[#262626] text-[#e5e5e5]' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium truncate">
                                    {{ $chat->title ?: 'New Chat' }}
                                </h3>
                                <p class="text-xs {{ $currentChatId == $chat->id ? 'text-white/70' : 'text-[#a3a3a3]' }} mt-1">
                                    {{ $chat->updated_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            <!-- Delete Button (visible on hover) -->
                            <form action="{{ route('gemini.delete') }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                                <button type="submit" 
                                        class="p-1 text-red-400 hover:text-red-300 hover:bg-red-400/10 rounded transition-all duration-200"
                                        onclick="return confirm('Are you sure you want to delete this chat?')"
                                        title="Delete chat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </a>
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-8">
                    <div class="w-12 h-12 bg-[#333333] rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#a3a3a3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <p class="text-[#a3a3a3] text-sm">No conversations yet</p>
                    <p class="text-[#666666] text-xs mt-1">Start a new chat to begin</p>
                </div>
            @endforelse
        </div>
    </div>
</div> 