@extends('layouts.app')

@section('title', 'Progress - AI Learning Platform')

@section('content')
<section style="max-width: 1000px; margin: 32px auto; padding: 0 16px;">
    <h1 style="margin: 0 0 8px;">Progress Report</h1>
    <p style="margin: 0 0 18px; color: #6b7280;">Track your current learning metrics.</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-bottom: 18px;">
        <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px;">
            <div style="color: #6b7280; font-size: 13px;">Total Courses</div>
            <div style="font-size: 24px; font-weight: 700;">{{ $progress->total_courses }}</div>
        </div>
        <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px;">
            <div style="color: #6b7280; font-size: 13px;">Completed Lessons</div>
            <div style="font-size: 24px; font-weight: 700;">{{ $progress->completed_lessons }}</div>
        </div>
        <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px;">
            <div style="color: #6b7280; font-size: 13px;">Average Progress</div>
            <div style="font-size: 24px; font-weight: 700;">{{ $progress->average_progress }}%</div>
        </div>
        <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px;">
            <div style="color: #6b7280; font-size: 13px;">Streak</div>
            <div style="font-size: 24px; font-weight: 700;">{{ $progress->streak_days }} days</div>
        </div>
    </div>

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px;">
        <h2 style="margin-top: 0;">Enrolled Courses</h2>
        <ul style="margin: 0; padding-left: 18px;">
            @forelse($courses as $course)
                <li>{{ $course->title }} - {{ (int) ($course->pivot->progress ?? 0) }}%</li>
            @empty
                <li>No enrolled courses yet.</li>
            @endforelse
        </ul>
    </div>
</section>
@endsection
