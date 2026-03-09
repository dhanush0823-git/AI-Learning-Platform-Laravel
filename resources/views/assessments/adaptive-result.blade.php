@extends('layouts.app')

@section('title', 'Adaptive Assessment Result')

@section('content')
<section style="max-width: 900px; margin: 28px auto; padding: 0 16px;">
    <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:16px;">
        <h1 style="margin:0;">Assessment Result</h1>
        <p style="margin:6px 0 18px; color:#6b7280;">Adaptive assessment summary and improvement areas.</p>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:10px; margin-bottom:14px;">
            <div style="border:1px solid #e5e7eb; border-radius:10px; padding:10px;">
                <p style="margin:0; color:#6b7280; font-size:12px;">Score</p>
                <p style="margin:6px 0 0; font-size:24px; font-weight:800;">{{ (int) $assessment->score }} / {{ (int) $answered }}</p>
            </div>
            <div style="border:1px solid #e5e7eb; border-radius:10px; padding:10px;">
                <p style="margin:0; color:#6b7280; font-size:12px;">Percentage</p>
                <p style="margin:6px 0 0; font-size:24px; font-weight:800;">{{ $percentage }}%</p>
            </div>
            <div style="border:1px solid #e5e7eb; border-radius:10px; padding:10px;">
                <p style="margin:0; color:#6b7280; font-size:12px;">Time Taken</p>
                <p style="margin:6px 0 0; font-size:24px; font-weight:800;">{{ (int) round(((int) $assessment->time_taken) / 60) }}m</p>
            </div>
        </div>

        <h3 style="margin:8px 0 10px;">Topics to Improve</h3>
        @if($weakTopics->isEmpty())
            <p style="margin:0; color:#6b7280;">No weak topics found yet.</p>
        @else
            <div style="display:grid; gap:8px;">
                @foreach($weakTopics as $topic)
                    <div style="border:1px solid #e5e7eb; border-radius:8px; padding:10px 12px; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-weight:600;">{{ $topic->topic }}</span>
                        <span style="font-size:12px; color:#6b7280;">Accuracy {{ $topic->accuracy }}% ({{ $topic->total }} Q)</span>
                    </div>
                @endforeach
            </div>
        @endif

        <div style="display:flex; gap:8px; margin-top:14px; flex-wrap:wrap;">
            <a href="{{ route('assessments', [], false) }}" style="padding:10px 14px; background:#2563eb; color:#fff; border-radius:8px; text-decoration:none; font-weight:600;">Back to Assessments</a>
            <a href="{{ route('learn', [], false) }}" style="padding:10px 14px; background:#111827; color:#fff; border-radius:8px; text-decoration:none; font-weight:600;">Continue Learning</a>
        </div>
    </div>
</section>
@endsection

