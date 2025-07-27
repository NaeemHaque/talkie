<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    public function getResponse(Request $request)
    {
        $sessionId = $request->session()->getId();
        $chatId = $request->input('chat_id');

        // If no chat_id provided, get the latest chat or create a new one
        if (!$chatId) {
            $chat = Chat::getLatestBySession($sessionId);
            if (!$chat) {
                $chat = Chat::createChat($sessionId);
            }
            $chatId = $chat->id;
        } else {
            $chat = Chat::find($chatId);
            if (!$chat) {
                return redirect()->route('gemini.chat')->with('error', 'Chat not found.');
            }
        }

        $conversations = Conversation::getByChat($chatId);
        $prompt = Arr::get($request, 'prompt');

        if (empty($prompt)) {
            return view('gemini', [
                'chat' => $chat,
                'conversations' => $conversations,
                'chats' => Chat::getBySession($sessionId)
            ]);
        }

        $request->validate([
            'prompt' => 'required|string|max:10000',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,txt,doc,docx|max:10240' // 10MB max
        ]);

        $fileData = [];
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileData = [
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'type' => $file->getMimeType()
            ];
        }

        $conversation = Conversation::createEntry(
            $chatId,
            $prompt,
            null,
            $fileData
        );

        // Update chat title if this is the first message
        if ($conversations->isEmpty()) {
            $chat->updateTitleFromFirstMessage();
        }

        try {
            $apiKey = config('services.gemini.secret');

            $conversationContext = $this->buildConversationContext($conversations, $prompt);

            $response = Http::timeout(30)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$apiKey",
                [
                    "contents" => $conversationContext,
                    "generationConfig" => [
                        "temperature" => 0.7,
                        "maxOutputTokens" => 2048,
                    ]
                ]
            );

            if ($response->successful()) {
                $aiResponse = $response->json('candidates.0.content.parts.0.text');

                $conversation->updateResponse($aiResponse ?? 'Sorry, I could not generate a response.');
            } else {
                $conversation->updateResponse('Sorry, there was an error processing your request. Please try again.');
            }

        } catch (\Exception $e) {
            $conversation->updateResponse('Sorry, I\'m temporarily unavailable. Please try again later.');

            Log::error('Gemini API Error: ' . $e->getMessage());
        }

        $conversations = Conversation::getByChat($chatId);

        return view('gemini', [
            'chat' => $chat,
            'conversations' => $conversations,
            'chats' => Chat::getBySession($sessionId)
        ]);
    }

    private function buildConversationContext($previousConversations, $currentPrompt)
    {
        $contents = [];

        // Add previous conversation context (last 10 exchanges to avoid token limits)
        $recentConversations = $previousConversations->take(-10);

        foreach ($recentConversations as $conv) {
            $contents[] = [
                "role" => "user",
                "parts" => [["text" => $conv->user_message]]
            ];

            if ($conv->ai_response) {
                $contents[] = [
                    "role" => "model",
                    "parts" => [["text" => $conv->ai_response]]
                ];
            }
        }

        $contents[] = [
            "role" => "user",
            "parts" => [["text" => $currentPrompt]]
        ];

        return $contents;
    }

    public function clearConversation(Request $request)
    {
        $chatId = $request->input('chat_id');

        if ($chatId) {
            $chat = Chat::find($chatId);
            if ($chat) {
                $chat->deleteChat();
            }
        }

        return redirect()->route('gemini.chat')->with('success', 'Conversation cleared successfully!');
    }

    public function newConversation(Request $request)
    {
        $sessionId = $request->session()->getId();
        $chat = Chat::createChat($sessionId);

        return redirect()->route('gemini.chat', ['chat_id' => $chat->id])->with('success', 'New conversation started!');
    }

    public function deleteChat(Request $request)
    {
        $chatId = $request->input('chat_id');
        $chat = Chat::find($chatId);

        if ($chat) {
            $chat->deleteChat();
            return redirect()->route('gemini.chat')->with('success', 'Chat deleted successfully!');
        }

        return redirect()->back()->with('error', 'Chat not found.');
    }

    public function loadChat(Request $request, $chatId)
    {
        $chat = Chat::getWithConversations($chatId);

        if (!$chat) {
            return redirect()->route('gemini.chat')->with('error', 'Chat not found.');
        }

        return view('gemini', [
            'chat' => $chat,
            'conversations' => $chat->conversations,
            'chats' => Chat::getBySession($request->session()->getId())
        ]);
    }
}
