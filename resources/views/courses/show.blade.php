@extends('layouts.app')

@section('title', ($course->title ?? 'Course') . ' - AI Learning Platform')

@section('content')
<section style="max-width: 1000px; margin: 32px auto; padding: 0 16px;">
    <p style="margin: 0 0 14px;">
        <a href="{{ route('courses', [], false) }}" style="color: #2563eb; text-decoration: none;">&larr; Back to Courses</a>
    </p>

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 16px;">
        <div style="display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
            <div>
                <h1 style="margin: 0 0 8px;">{{ $course->title }}</h1>
                <p style="margin: 0; color: #6b7280;">{{ $course->description }}</p>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 12px; color: #6b7280;">Department</div>
                <div style="font-weight: 700;">{{ $course->department->code ?? '-' }}</div>
                <div style="font-size: 12px; color: #6b7280; margin-top: 8px;">Level: {{ ucfirst($course->difficulty) }}</div>
            </div>
        </div>
    </div>

    <h2 style="margin: 0 0 12px;">Modules</h2>
    <div style="display: grid; gap: 12px;">
        @forelse($course->modules as $module)
            <article style="background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px;">
                <h3 style="margin: 0 0 6px;">
                    Module {{ $module->module_number }}: {{ $module->title }}
                </h3>
                <p style="margin: 0 0 10px; color: #6b7280;">{{ $module->description }}</p>

                <div style="font-size: 13px; color: #4b5563; margin-bottom: 8px;">
                    Lessons: {{ $module->lessons->count() }}
                </div>

                @if($module->lessons->isNotEmpty())
                    <ul style="margin: 0; padding-left: 18px; color: #374151;">
                        @foreach($module->lessons as $lesson)
                            <li>
                                Lesson {{ $lesson->lesson_number }} - {{ $lesson->title }}
                                <span style="color: #6b7280;">({{ $lesson->lesson_type }})</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </article>
        @empty
            <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px;">
                No modules available for this course yet.
            </div>
        @endforelse
    </div>
</section>
@endsection
