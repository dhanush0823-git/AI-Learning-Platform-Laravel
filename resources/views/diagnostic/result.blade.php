@extends('layouts.app')

@section('title', 'Diagnostic Result - AI Learning Platform')

@section('content')
<section style="max-width: 700px; margin: 36px auto; padding: 0 16px 32px;">
    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 20px;">
        <h1 style="margin: 0 0 10px;">Diagnostic Result</h1>
        <p style="margin: 0 0 16px; color: #6b7280;">Completed on {{ optional($attempt->completed_at)->format('d M Y, h:i A') }}</p>

        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 10px; margin-bottom: 18px;">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px;">
                <div style="font-size: 12px; color: #64748b;">Score</div>
                <div style="font-size: 20px; font-weight: 700;">{{ $attempt->score }}/{{ $attempt->total_questions }}</div>
            </div>
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px;">
                <div style="font-size: 12px; color: #64748b;">Percentage</div>
                <div style="font-size: 20px; font-weight: 700;">{{ number_format($attempt->percentage, 2) }}%</div>
            </div>
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px;">
                <div style="font-size: 12px; color: #64748b;">Assigned Level</div>
                <div style="font-size: 20px; font-weight: 700;">{{ ucfirst($attempt->assigned_level) }}</div>
            </div>
        </div>

        <p style="margin: 0 0 16px; color: #334155;">
            Your profile level has been updated to <strong>{{ strtoupper($attempt->assigned_level) }}</strong>.
        </p>

        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('courses', [], false) }}" style="padding: 10px 16px; border-radius: 10px; background: #2563eb; color: #fff; text-decoration: none; font-weight: 600;">
                Go to Courses
            </a>
            <a href="{{ route('diagnostic.test', [], false) }}" style="padding: 10px 16px; border-radius: 10px; background: #f1f5f9; color: #334155; text-decoration: none; font-weight: 600;">
                Retake Test
            </a>
        </div>
    </div>
</section>
@endsection
