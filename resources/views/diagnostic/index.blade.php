@extends('layouts.app')

@section('title', 'Diagnostic Test - AI Learning Platform')

@section('content')
<section style="max-width: 1000px; margin: 32px auto; padding: 0 16px 32px;">
    <h1 style="margin: 0 0 8px;">Diagnostic Test</h1>
    <p style="margin: 0 0 18px; color: #6b7280;">
        Department-based assessment to set your learning level.
    </p>

    @if(session('warning'))
        <div style="background: #fff7ed; border: 1px solid #fdba74; color: #9a3412; padding: 12px 14px; border-radius: 10px; margin-bottom: 14px;">
            {{ session('warning') }}
        </div>
    @endif

    @if($latestAttempt)
        <div style="background: #ecfeff; border: 1px solid #67e8f9; color: #0f766e; padding: 12px 14px; border-radius: 10px; margin-bottom: 14px;">
            Last score: {{ $latestAttempt->score }}/{{ $latestAttempt->total_questions }}
            ({{ number_format($latestAttempt->percentage, 2) }}%) - Level: {{ ucfirst($latestAttempt->assigned_level) }}
            <a href="{{ route('diagnostic.result', ['attemptId' => $latestAttempt->id], false) }}" style="margin-left: 10px; color: #0e7490; text-decoration: none; font-weight: 600;">
                View Result
            </a>
        </div>
    @endif

    @if($questions->isEmpty())
        <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px;">
            No diagnostic questions are available for your department yet.
        </div>
    @else
        <form method="POST" action="{{ route('diagnostic.submit', [], false) }}" style="display: grid; gap: 14px;">
            @csrf

            @foreach($questions as $index => $question)
                <article style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px;">
                    <h3 style="margin: 0 0 10px; font-size: 17px;">
                        Q{{ $index + 1 }}. {{ $question->question }}
                    </h3>
                    <div style="display: grid; gap: 8px;">
                        @foreach(['a', 'b', 'c', 'd'] as $opt)
                            @php $field = "option_{$opt}"; @endphp
                            <label style="display: flex; gap: 8px; align-items: flex-start; cursor: pointer;">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $opt }}" required>
                                <span>{{ strtoupper($opt) }}. {{ $question->{$field} }}</span>
                            </label>
                        @endforeach
                    </div>
                </article>
            @endforeach

            <button type="submit" style="justify-self: start; padding: 10px 18px; border: none; border-radius: 10px; background: #2563eb; color: #fff; font-weight: 700; cursor: pointer;">
                Submit Diagnostic Test
            </button>
        </form>
    @endif
</section>
@endsection
