@extends('layouts.app')

@section('title', 'Student Report - ' . ($student->name ?? 'Student'))

@section('content')
<section style="max-width: 1100px; margin: 32px auto; padding: 0 16px;">
    <div style="margin-bottom: 16px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="margin:0;">{{ $student->name }} ({{ $student->email }})</h1>
            <p style="margin:4px 0 0;color:#6b7280;">Department: {{ $department->code ?? 'N/A' }}</p>
        </div>
        <a href="{{ route('department.reports') }}" style="padding:8px 12px;background:#2563eb;color:#fff;border-radius:8px;text-decoration:none;">Back</a>
    </div>

    <div style="display:grid; gap:12px;">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;">
            <h2 style="margin:0 0 10px;">Diagnostic Test</h2>
            @if($latestDiagnostic)
                <p>Score: {{ $latestDiagnostic->score }} / {{ $latestDiagnostic->total_questions }} ({{ round($latestDiagnostic->percentage,2) }}%)</p>
                <p>Level: {{ ucfirst($latestDiagnostic->assigned_level) }}</p>
                <p>Date: {{ $latestDiagnostic->completed_at ? $latestDiagnostic->completed_at->format('Y-m-d H:i') : 'N/A' }}</p>
            @else
                <p style="color:#6b7280;">No diagnostic attempt found.</p>
            @endif
        </div>

        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;">
            <h2 style="margin:0 0 10px;">Module Test Scores</h2>
            @if($moduleTests->isEmpty())
                <p style="color:#6b7280;">No module tests available.</p>
            @else
                <table style="width:100%;border-collapse:collapse;font-size:0.95rem;">
                    <thead>
                        <tr style="background:#f8fafc;"><th style="padding:8px">Module</th><th style="padding:8px">Score</th><th style="padding:8px">Status</th><th style="padding:8px"></th></tr>
                    </thead>
                    <tbody>
                        @foreach($moduleTests as $test)
                            <tr>
                                <td style="padding:8px">{{ $test->module->title ?? 'Module ' . $test->module_id }}</td>
                                <td style="padding:8px">{{ $test->score }} / {{ $test->total_questions }} ({{ $test->total_questions ? round(($test->score/$test->total_questions)*100,2) : 0 }}%)</td>
                                <td style="padding:8px">{{ $test->completed_at ? 'Completed' : 'In Progress' }}</td>
                                <td style="padding:8px"><a href="{{ route('assessments.adaptive.result', $test) }}" style="color:#2563eb;">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</section>
@endsection