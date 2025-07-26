<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Talkie - Modern Chat</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans bg-[#0f0f0f] text-[#e5e5e5]">
<!-- Header -->
<header class="bg-[#1a1a1a] border-b border-[#333333] sticky top-0 z-50 backdrop-blur-sm">
    <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="relative">
                <div class="w-10 h-10 bg-[#5b6df0] rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-[#e5e5e5]">Talkie</h1>
                <p class="text-xs text-[#a3a3a3]">Powered by Gemini</p>
            </div>
        </div>

        <!-- Chat Controls -->
        <div class="flex items-center gap-3">
            @if(isset($conversations) && $conversations->isNotEmpty())
                <form action="{{ route('gemini.new') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="p-2 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-all duration-200"
                            title="New Chat">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </form>

                <form action="{{ route('gemini.clear') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="p-2 text-[#a3a3a3] hover:text-red-400 hover:bg-[#262626] rounded-lg transition-all duration-200"
                            title="Clear Chat"
                            onclick="return confirm('Are you sure you want to clear this conversation?')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            @endif

            <button onclick="toggleTheme()"
                    class="p-2 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </button>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="max-w-5xl mx-auto px-6 py-8 min-h-[calc(100vh-140px)] flex flex-col">

    <div id="messages" class="flex-1 mb-8 space-y-6 max-h-[60vh] overflow-y-auto">

        @if(!isset($conversations) || $conversations->isEmpty())
            <div class="text-center py-16 animate-fade-in">
                <div
                    class="w-16 h-16 bg-[#5b6df0] rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg animate-subtle-glow">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-[#e5e5e5] mb-4">
                    Let's get started
                </h2>
                <p class="text-[#a3a3a3] text-lg max-w-lg mx-auto">
                    Ask me anything! I'm here to help you with your questions and tasks.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-4xl mx-auto">
                <button onclick="fillPrompt('Write a creative story about space exploration')"
                        class="group p-6 bg-[#1a1a1a] border border-[#333333] hover:border-[#5b6df0] rounded-xl transition-all duration-200 text-left hover:bg-[#262626]">
                    <div
                        class="w-10 h-10 bg-[#6366f1] rounded-lg flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-[#e5e5e5] mb-2">Creative Writing</h3>
                    <p class="text-[#a3a3a3] text-sm">Generate stories and creative content</p>
                </button>

                <button onclick="fillPrompt('Help me debug this PHP code')"
                        class="group p-6 bg-[#1a1a1a] border border-[#333333] hover:border-[#5b6df0] rounded-xl transition-all duration-200 text-left hover:bg-[#262626]">
                    <div
                        class="w-10 h-10 bg-[#06b6d4] rounded-lg flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-[#e5e5e5] mb-2">Code Help</h3>
                    <p class="text-[#a3a3a3] text-sm">Debug and improve your code</p>
                </button>

                <button onclick="fillPrompt('Explain quantum computing in simple terms')"
                        class="group p-6 bg-[#1a1a1a] border border-[#333333] hover:border-[#5b6df0] rounded-xl transition-all duration-200 text-left hover:bg-[#262626] md:col-span-2 lg:col-span-1">
                    <div
                        class="w-10 h-10 bg-[#10b981] rounded-lg flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9.663 17h4.673M12 3v1m6.364-.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-[#e5e5e5] mb-2">Learn Concepts</h3>
                    <p class="text-[#a3a3a3] text-sm">Understand complex topics</p>
                </button>
            </div>
        @else
            <!-- Conversation History -->
            @foreach($conversations as $conversation)
                <!-- User Message -->
                <div class="flex justify-end animate-slide-up">
                    <div class="max-w-3xl">
                        <div class="bg-[#5b6df0] text-white rounded-2xl rounded-br-lg px-5 py-3 shadow-lg">
                            <p class="text-sm leading-relaxed">{{ $conversation->user_message }}</p>
                            @if(isset($conversation->metadata['filename']))
                                <div class="mt-2 p-2 bg-white/10 rounded-lg flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-xs">{{ $conversation->metadata['filename'] }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center justify-end gap-3 mt-2 px-1">
                            <span class="text-xs text-[#a3a3a3]">{{ $conversation->created_at->format('H:i') }}</span>
                            <span class="text-xs text-[#a3a3a3]">You</span>
                            <div class="w-6 h-6 bg-[#5b6df0] rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Response -->
                @if($conversation->ai_response)
                    <div class="flex justify-start animate-slide-up">
                        <div class="max-w-3xl">
                            <div class="flex items-center gap-3 mb-2 px-1">
                                <div class="w-6 h-6 bg-[#6366f1] rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs text-[#a3a3a3]">Talkie</span>
                                <span
                                    class="text-xs text-[#a3a3a3]">{{ $conversation->created_at->format('H:i') }}</span>
                            </div>
                            <div
                                class="bg-[#1a1a1a] border border-[#333333] rounded-2xl rounded-bl-lg px-5 py-3 shadow-lg">
                                <div class="prose prose-sm dark:prose-invert max-w-none text-[#e5e5e5]">
                                    {!! nl2br(e($conversation->ai_response)) !!}
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mt-2 px-1">
                                <button
                                    class="p-1.5 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-colors"
                                    title="Copy response"
                                    onclick="copyToClipboard({{ json_encode($conversation->ai_response) }})">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                                <button
                                    class="p-1.5 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-colors"
                                    title="Regenerate">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Loading state for AI response -->
                    <div class="flex justify-start animate-slide-up">
                        <div class="max-w-3xl">
                            <div class="flex items-center gap-3 mb-2 px-1">
                                <div
                                    class="w-6 h-6 bg-[#6366f1] rounded-full flex items-center justify-center animate-pulse">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs text-[#a3a3a3]">Talkie</span>
                            </div>
                            <div
                                class="bg-[#1a1a1a] border border-[#333333] rounded-2xl rounded-bl-lg px-5 py-3 shadow-lg">
                                <div class="flex items-center gap-2 text-[#a3a3a3]">
                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-[#5b6df0]"></div>
                                    <span class="text-sm">Thinking...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        <!-- Legacy Support - Keep existing $response logic for backward compatibility -->
        @if(isset($response) && (!isset($conversations) || $conversations->isEmpty()))
            <!-- User Message -->
            <div class="flex justify-end animate-slide-up">
                <div class="max-w-3xl">
                    <div class="bg-[#5b6df0] text-white rounded-2xl rounded-br-lg px-5 py-3 shadow-lg">
                        <p class="text-sm leading-relaxed">{{ $last_prompt ?? 'Your message' }}</p>
                    </div>
                    <div class="flex items-center justify-end gap-3 mt-2 px-1">
                        <span class="text-xs text-[#a3a3a3]">You</span>
                        <div class="w-6 h-6 bg-[#5b6df0] rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI Response -->
            <div class="flex justify-start animate-slide-up">
                <div class="max-w-3xl">
                    <div class="flex items-center gap-3 mb-2 px-1">
                        <div class="w-6 h-6 bg-[#6366f1] rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="text-xs text-[#a3a3a3]">Talkie</span>
                    </div>
                    <div class="bg-[#1a1a1a] border border-[#333333] rounded-2xl rounded-bl-lg px-5 py-3 shadow-lg">
                        <div class="prose prose-sm dark:prose-invert max-w-none text-[#e5e5e5]">
                            {!! nl2br(e($response)) !!}
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-2 px-1">
                        <button
                            class="p-1.5 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-colors"
                            title="Copy response"
                            onclick="copyToClipboard({{ json_encode($response) }})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                        <button
                            class="p-1.5 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-colors"
                            title="Regenerate">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Input Form -->
    <div class="sticky bottom-0 pt-6">
        <form action="/" method="POST" enctype="multipart/form-data" class="relative max-w-4xl mx-auto">
            @csrf

            <!-- File Preview -->
            <div id="file-preview" class="hidden mb-4">
                <div class="bg-[#1a1a1a] border border-[#333333] rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-[#5b6df0] rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p id="file-name" class="text-sm font-medium text-[#e5e5e5]"></p>
                            <p id="file-size" class="text-xs text-[#a3a3a3]"></p>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile()"
                            class="p-1.5 text-[#a3a3a3] hover:text-[#e5e5e5] hover:bg-[#262626] rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Input Container -->
            <div
                class="relative bg-[#1a1a1a] border border-[#333333] rounded-2xl shadow-lg focus-within:border-[#5b6df0] transition-all duration-200">
                <div class="flex items-end gap-4 p-4">

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
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
</main>

<script>
    function toggleTheme() {
        console.log('Theme toggle - currently using dark mode only');
    }

    const textarea = document.getElementById('prompt-input');
    textarea.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 128) + 'px';
    });

    textarea.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            this.closest('form').submit();
        }
    });

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('file-name').textContent = file.name;
            document.getElementById('file-size').textContent = formatFileSize(file.size);
            document.getElementById('file-preview').classList.remove('hidden');
        }
    }

    function removeFile() {
        document.getElementById('file-input').value = '';
        document.getElementById('file-preview').classList.add('hidden');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function fillPrompt(text) {
        document.getElementById('prompt-input').value = text;
        document.getElementById('prompt-input').focus();
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function () {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
            toast.textContent = 'Copied to clipboard!';
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 2000);
        }).catch(function () {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);

            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
            toast.textContent = 'Copied to clipboard!';
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 2000);
        });
    }

    window.addEventListener('load', function () {
        document.getElementById('prompt-input').focus();

        @if(isset($conversations) && $conversations->isNotEmpty())
        const messagesContainer = document.getElementById('messages');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        @endif
    });

    document.querySelector('form').addEventListener('submit', function () {
        setTimeout(() => {
            const messagesContainer = document.getElementById('messages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            document.getElementById('prompt-input').value = '';
            document.getElementById('prompt-input').style.height = 'auto';
        }, 100);
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        const sendBtn = document.getElementById('send-btn');
        const originalContent = sendBtn.innerHTML;

        sendBtn.innerHTML = `
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
            <span class="text-sm">Sending...</span>
        `;
        sendBtn.disabled = true;

        setTimeout(() => {
            sendBtn.innerHTML = originalContent;
            sendBtn.disabled = false;
        }, 10000);
    });

    @if(isset($response) && (!isset($conversations) || $conversations->isEmpty()))
    window.addEventListener('load', function () {
        document.getElementById('messages').scrollIntoView({behavior: 'smooth', block: 'end'});
    });
    @endif
</script>
</body>
</html>
