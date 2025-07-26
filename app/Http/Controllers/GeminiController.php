<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    public function index()
    {
        return view('gemini', [
            'response'    => null,
            'last_prompt' => null,
        ]);
    }

    public function getResponse(Request $request)
    {
        $prompt = Arr::get($request, 'prompt');
        if (empty($prompt)) {
            return view('gemini');
        }

        $apiKey = config('services.gemini.secret');
        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey", [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => $prompt,
                        ]
                    ]
                ]
            ]
        ])->json('candidates.0.content.parts.0.text');

        return view('gemini', [
            'response'    => $response ?? [],
            'last_prompt' => $prompt,
        ]);
    }
}
