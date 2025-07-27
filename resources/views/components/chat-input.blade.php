<!-- Input Form -->
<div class="sticky bottom-0 pt-6">
    <form action="/" method="POST" enctype="multipart/form-data" class="relative max-w-4xl mx-auto">
        @csrf

        <!-- Hidden chat_id field -->
        @if(isset($chat))
            <input type="hidden" name="chat_id" value="{{ $chat->id }}">
        @endif

        <!-- File Preview -->
        <x-file-preview />

        <!-- Input Container -->
        <div class="relative bg-[#1a1a1a] border border-[#333333] rounded-2xl shadow-lg focus-within:border-[#5b6df0] transition-all duration-200">
            <div class="flex items-end gap-4 px-4 py-2">

                <!-- Text Input -->
                <div class="flex-1">
                    <textarea
                        id="prompt-input"
                        name="prompt"
                        class="w-full bg-transparent text-[#e5e5e5] placeholder-[#a3a3a3] outline-none resize-none text-base leading-6 min-h-[24px] max-h-32"
                        placeholder="Type your message..."
                        rows="1"
                        autocomplete="off"
                        required
                    ></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3">

                    <!-- Upload Button -->
                    <button
                        type="button"
                        onclick="document.getElementById('file-input').click()"
                        class="p-2.5 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-xl transition-all duration-200"
                        title="Attach file"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                    </button>

                    <!-- Send Button -->
                    <button
                        type="submit"
                        class="bg-[#5b6df0] hover:bg-[#4c5dd4] text-white rounded-xl px-5 py-2.5 font-medium transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl"
                        id="send-btn"
                    >
                        <span class="text-sm">Send</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>

                </div>
            </div>
        </div>

        <!-- Hidden File Input -->
        <input
            type="file"
            id="file-input"
            name="file"
            class="hidden"
            accept="image/*,.pdf,.doc,.docx,.txt"
            onchange="handleFileSelect(event)"
        >

    </form>

    <!-- Footer Info -->
    <div class="text-center mt-6">
        <p class="text-xs text-[#a3a3a3]">
            Talkie can make mistakes. Consider checking important information.
        </p>
    </div>
</div>
