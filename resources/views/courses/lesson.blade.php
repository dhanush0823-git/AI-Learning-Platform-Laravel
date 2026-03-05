@extends('layouts.app')

@section('title', ($lesson->title ?? 'Lesson') . ' - AI Learning Platform')

@section('content')
<section style="max-width: 1000px; margin: 32px auto; padding: 0 16px 32px;">
    <p style="margin: 0 0 14px;">
        <a href="{{ route('courses.show', ['id' => $course->id], false) }}" style="color: #2563eb; text-decoration: none;">
            &larr; Back to {{ $course->title }}
        </a>
    </p>

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px;">
        <div style="font-size: 13px; color: #6b7280; margin-bottom: 10px;">
            {{ $course->title }} / Module {{ $module->module_number }}: {{ $module->title }}
        </div>

        <h1 style="margin: 0 0 6px; font-size: 30px;">
            Lesson {{ $lesson->lesson_number }}: {{ $lesson->title }}
        </h1>

        <p style="margin: 0 0 18px; color: #6b7280;">
            Type: {{ ucfirst($lesson->lesson_type ?? 'lesson') }}
            @if($lesson->duration)
                | Duration: {{ $lesson->duration }} min
            @endif
        </p>

        @if(! empty($lesson->video_url))
            <p style="margin: 0 0 18px;">
                <a href="{{ $lesson->video_url }}" target="_blank" rel="noopener noreferrer" style="color: #2563eb; text-decoration: none;">
                    Open lesson video
                </a>
            </p>
        @endif

        <div style="line-height: 1.7; color: #1f2937;">
            {!! \Illuminate\Support\Str::markdown($lesson->content ?? '', ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
        </div>
    </div>
</section>
@endsection
