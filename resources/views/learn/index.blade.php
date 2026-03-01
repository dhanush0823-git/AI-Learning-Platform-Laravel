@extends('layouts.app')

@section('title', 'Learning Path - AI Learning Platform')

@section('content')
<section style="max-width: 1100px; margin: 32px auto; padding: 0 16px;">
    <h1 style="margin: 0 0 8px;">Learning Path</h1>
    <p style="margin: 0 0 18px; color: #6b7280;">Continue where you left off.</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
        @forelse($courses as $course)
            <article style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px;">
                <h3 style="margin: 0 0 8px;">{{ $course->title }}</h3>
                <p style="margin: 0 0 10px; color: #6b7280;">{{ $course->description }}</p>
                <div style="font-size: 13px; color: #4b5563; margin-bottom: 8px;">
                    Progress: {{ (int) ($course->pivot->progress ?? 0) }}%
                </div>
                <a href="{{ route('learn.course', $course->id) }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">
                    Open Course
                </a>
            </article>
        @empty
            <div style="grid-column: 1 / -1; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px;">
                You are not enrolled in any courses yet.
            </div>
        @endforelse
    </div>
</section>
@endsection
