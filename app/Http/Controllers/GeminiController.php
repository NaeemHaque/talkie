<?php

namespace App\Http\Controllers;

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

        $conversations = Conversation::getLatestBySession($sessionId);

        $prompt = Arr::get($request, 'prompt');

        if (empty($prompt)) {
            return view('gemini', [
                'conversations' => $conversations
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


//             $filePath = $file->store('chat-files', 'public');
//             $fileData['path'] = $filePath;
        }

        $conversation = Conversation::createEntry(
            $sessionId,
            $prompt,
            null,
            $fileData
        );

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

        $conversations = Conversation::getLatestBySession($sessionId);

        return view('gemini', [
            'conversations' => $conversations
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
        $sessionId = $request->session()->getId();
        Conversation::where('session_id', $sessionId)->delete();

        return redirect()->back()->with('success', 'Conversation cleared successfully!');
    }


    public function newConversation(Request $request)
    {
        $request->session()->regenerate();

        return redirect()->route('gemini.chat')->with('success', 'New conversation started!');
    }

}
