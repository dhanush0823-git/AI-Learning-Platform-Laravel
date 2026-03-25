@extends('layouts.app')

@section('title', 'Module Marks - ' . ($course->title ?? 'Course'))

@section('content')
<section style="max-width: 1100px; margin: 32px auto; padding: 0 16px;">
    <div style="margin-bottom:16px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="margin:0;">{{ $course->title }}</h1>
            <p style="margin:4px 0 0;color:#6b7280;">Department: {{ $department->code ?? 'N/A' }}</p>
        </div>
        <a href="{{ route('department.reports') }}" style="padding:8px 12px;background:#2563eb;color:#fff;border-radius:8px;text-decoration:none;">Back</a>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;">
        <h2 style="margin:0 0 10px;">Student Module Test Marks</h2>
        @if($moduleAssessments->isEmpty())
            <p style="color:#6b7280;">No module test records found for this course.</p>
        @else
            <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.95rem;">
                <thead>
                    <tr style="background:#f8fafc;"><th style="padding:8px;text-align:left">Student</th><th style="padding:8px;text-align:left">Module</th><th style="padding:8px;text-align:left">Score</th><th style="padding:8px;text-align:left">Percentage</th><th style="padding:8px;text-align:left">Status</th><th style="padding:8px;text-align:left">Action</th></tr>
                </thead>
                <tbody>
                    @foreach($moduleAssessments as $assessment)
                        <tr>
                            <td style="padding:8px">{{ $assessment->student->name ?? 'Student' }}</td>
                            <td style="padding:8px">{{ $assessment->module->title ?? 'Module' }}</td>
                            <td style="padding:8px">{{ $assessment->score }} / {{ $assessment->total_questions }}</td>
                            <td style="padding:8px">{{ $assessment->total_questions ? round(($assessment->score/$assessment->total_questions)*100,2) : 0 }}%</td>
                            <td style="padding:8px">{{ $assessment->completed_at ? 'Completed' : 'Open' }}</td>
                            <td style="padding:8px"><a href="{{ route('assessments.adaptive.result', $assessment) }}" style="color:#2563eb;">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>
@endsection