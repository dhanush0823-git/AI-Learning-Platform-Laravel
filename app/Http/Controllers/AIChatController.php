<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $messageText = trim($validated['message']);
        $normalizedHash = sha1(mb_strtolower($messageText));
        $lastSubmission = session('chat_last_submission');

        if (
            is_array($lastSubmission)
            && ($lastSubmission['hash'] ?? null) === $normalizedHash
            && (int) now()->timestamp - (int) ($lastSubmission['time'] ?? 0) <= 8
        ) {
            return redirect()->route('chat.index');
        }

        $messages = session('chat_messages', []);
        $messages[] = [
            'role' => 'user',
            'content' => $messageText,
        ];

        $assistantReply = $this->generateReply($messageText);

        $messages[] = [
            'role' => 'assistant',
            'content' => $assistantReply,
        ];

        session(['chat_messages' => $messages]);
        session([
            'chat_last_submission' => [
                'hash' => $normalizedHash,
                'time' => (int) now()->timestamp,
            ],
        ]);

        return redirect()->route('chat.index');
    }

    protected function generateReply(string $message): string
    {
        $apiKey = config('services.groq.key');
        $model = config('services.groq.model', 'llama-3.3-70b-versatile');

        $student = Auth::guard('student')->user();
        $departmentId = $student?->department_id ?? session('student_department_id');
        $departmentName = $student?->department?->name ?? 'Unknown';

        if (! $apiKey) {
            return 'AI chat is configured, but GROQ_API_KEY is missing. Add it in .env to enable live answers.';
        }

        $systemPrompt = 'You are a learning assistant for engineering students. '
            . 'Keep answers concise, practical, and beginner-friendly. '
            . 'The logged-in student department_id is: ' . ($departmentId ?? 'unknown')
            . '. Department name: ' . $departmentName . '. '
            . 'Prefer examples and explanations relevant to this department.';

        $response = Http::withToken($apiKey)
            ->timeout(20)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt,
                    ],
                    [
                        'role' => 'user',
                        'content' => $message,
                    ],
                ],
                'temperature' => 0.3,
            ]);

        if (! $response->successful()) {
            return 'Unable to fetch AI answer right now. Please try again.';
        }

        $text = data_get($response->json(), 'choices.0.message.content');

        return is_string($text) && $text !== ''
            ? $text
            : 'No response received from AI model.';
    }
}
