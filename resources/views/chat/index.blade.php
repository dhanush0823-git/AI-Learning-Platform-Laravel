@extends('layouts.app')

@section('title', 'AI Chat - AI Learning Platform')

@section('content')
<section style="max-width: 900px; margin: 32px auto; padding: 0 16px 32px;">
    <h1 style="margin: 0 0 8px;">AI Doubt Solver</h1>
    <p style="margin: 0 0 18px; color: #6b7280;">Ask your questions and get instant help.</p>

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; min-height: 260px; margin-bottom: 14px;">
        @forelse($messages as $message)
            <div style="margin-bottom: 10px; display: flex; justify-content: {{ $message['role'] === 'user' ? 'flex-end' : 'flex-start' }};">
                <div style="max-width: 80%; padding: 10px 12px; border-radius: 10px; background: {{ $message['role'] === 'user' ? '#dbeafe' : '#f3f4f6' }};">
                    <strong style="display: block; margin-bottom: 4px; font-size: 12px; color: #475569;">
                        {{ strtoupper($message['role']) }}
                    </strong>
                    <div style="white-space: pre-wrap;">{{ $message['content'] }}</div>
                </div>
            </div>
        @empty
            <p style="margin: 0; color: #9ca3af;">No conversation yet.</p>
        @endforelse
    </div>

    <form method="POST" action="{{ route('chat.ask', [], false) }}" style="display: flex; gap: 10px;">
        @csrf
        <input
            type="text"
            name="message"
            placeholder="Ask your doubt..."
            required
            style="flex: 1; border: 1px solid #d1d5db; border-radius: 10px; padding: 10px 12px;"
        >
        <button type="submit" style="padding: 10px 16px; border-radius: 10px; border: none; background: #2563eb; color: #fff; font-weight: 600; cursor: pointer;">
            Ask AI
        </button>
    </form>
</section>
@endsection
