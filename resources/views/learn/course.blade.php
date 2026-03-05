@extends('layouts.app')

@section('title', ($course->title ?? 'Course') . ' - Learning Path')

@section('content')
<section style="max-width: 1000px; margin: 32px auto; padding: 0 16px;">
    <p style="margin: 0 0 14px;">
        <a href="{{ route('learn', [], false) }}" style="color: #2563eb; text-decoration: none;">&larr; Back to Learning Path</a>
    </p>

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 16px;">
        <h1 style="margin: 0 0 6px;">{{ $course->title }}</h1>
        <p style="margin: 0; color: #6b7280;">{{ $course->description }}</p>
    </div>

    <h2 style="margin: 0 0 12px;">Modules & Lessons</h2>
    <div style="display: grid; gap: 12px;">
        @foreach($course->modules as $module)
            <article style="background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px;">
                <h3 style="margin: 0 0 8px;">Module {{ $module->module_number }}: {{ $module->title }}</h3>
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach($module->lessons as $lesson)
                        <li style="margin-bottom: 10px;">
                            <div>{{ $lesson->lesson_number }}. {{ $lesson->title }} ({{ $lesson->lesson_type }})</div>
                            @if(! empty($lesson->content))
                                <div style="margin-top: 6px; color: #374151;">
                                    {!! \Illuminate\Support\Str::markdown($lesson->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </article>
        @endforeach
    </div>
</section>
@endsection
