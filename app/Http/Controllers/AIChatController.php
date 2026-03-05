<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIChatController extends Controller
{
    public function index()
    {
        return view('chat.index', [
            'messages' => session('chat_messages', []),
        ]);
    }

    public function ask(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:4000',
        ]);

        $messages = session('chat_messages', []);
        $messages[] = [
            'role' => 'user',
            'content' => $validated['message'],
        ];

        $assistantReply = $this->generateReply($validated['message']);

        $messages[] = [
            'role' => 'assistant',
            'content' => $assistantReply,
        ];

        session(['chat_messages' => $messages]);

        return redirect()->route('chat.index');
    }

    protected function generateReply(string $message): string
    {
        $apiKey = config('services.openai.key');
        $model = config('services.openai.model', 'gpt-4.1-mini');

        if (! $apiKey) {
            return 'AI chat is configured, but OPENAI_API_KEY is missing. Add it in .env to enable live answers.';
        }

        $response = Http::withToken($apiKey)
            ->post('https://api.openai.com/v1/responses', [
                'model' => $model,
                'input' => [
                    [
                        'role' => 'system',
                        'content' => [
                            [
                                'type' => 'input_text',
                                'text' => 'You are a learning assistant for engineering students. Keep answers concise and practical.',
                            ],
                        ],
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'input_text',
                                'text' => $message,
                            ],
                        ],
                    ],
                ],
            ]);

        if (! $response->successful()) {
            return 'Unable to fetch AI answer right now. Please try again.';
        }

        $text = data_get($response->json(), 'output.0.content.0.text');

        return is_string($text) && $text !== ''
            ? $text
            : 'No response received from AI model.';
    }
}
