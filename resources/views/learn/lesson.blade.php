@extends('layouts.app')

@section('title', ($lesson->title ?? 'Lesson') . ' - Learning Path')

@section('content')
<section style="max-width: 1100px; margin: 32px auto; padding: 0 16px 32px;">
    <p style="margin: 0 0 14px;">
        <a href="{{ route('learn.course', ['id' => $course->id], false) }}" style="color: #2563eb; text-decoration: none;">
            &larr; Back to {{ $course->title }}
        </a>
    </p>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px;">
        <article style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px;">
            <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
                {{ $course->title }} / Module {{ $module->module_number }}: {{ $module->title }}
            </div>
            <h1 style="margin: 0 0 8px;">Lesson {{ $lesson->lesson_number }}: {{ $lesson->title }}</h1>
            <p style="margin: 0 0 14px; color: #64748b;">
                Type: {{ ucfirst($lesson->lesson_type) }}
                @if($lesson->duration) | Duration: {{ $lesson->duration }} min @endif
            </p>

            <div style="margin-bottom: 14px; padding: 10px 12px; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 10px;">
                Time spent on this lesson: <strong id="live-time">{{ (int) ($lessonProgress->time_spent ?? 0) }}</strong> sec
            </div>

            @if(! empty($lesson->video_url))
                <p style="margin: 0 0 14px;">
                    <a href="{{ $lesson->video_url }}" target="_blank" rel="noopener noreferrer" style="color: #2563eb; text-decoration: none;">
                        Open Video
                    </a>
                </p>
            @endif

            <div style="line-height: 1.75; color: #1f2937; margin-bottom: 18px;">
                {!! \Illuminate\Support\Str::markdown($lesson->content ?? '', ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
            </div>

            <form method="POST" action="{{ route('learn.lesson.complete', ['courseId' => $course->id, 'moduleId' => $module->id, 'lessonId' => $lesson->id], false) }}">
                @csrf
                <input type="hidden" id="complete-seconds" name="seconds" value="0">
                <button type="submit" style="padding: 10px 18px; border: none; border-radius: 10px; background: #2563eb; color: #fff; font-weight: 700; cursor: pointer;">
                    {{ $nextLesson ? 'Mark Complete & Next Lesson' : 'Mark Complete' }}
                </button>
            </form>
        </article>

        <aside style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px;">
            <h3 style="margin: 0 0 12px;">Other Lessons</h3>
            <div style="display: grid; gap: 8px;">
                @foreach($moduleLessons as $moduleLesson)
                    <a
                        href="{{ route('learn.lesson', ['courseId' => $course->id, 'moduleId' => $module->id, 'lessonId' => $moduleLesson->id], false) }}"
                        style="display: block; border-radius: 10px; padding: 10px 12px; border: 1px solid {{ (int) $moduleLesson->id === (int) $lesson->id ? '#93c5fd' : '#e5e7eb' }}; background: {{ (int) $moduleLesson->id === (int) $lesson->id ? '#eff6ff' : '#fff' }}; color: #0f172a; text-decoration: none;"
                    >
                        <div style="font-size: 12px; color: #64748b;">Lesson {{ $moduleLesson->lesson_number }}</div>
                        <div style="font-weight: 600;">{{ $moduleLesson->title }}</div>
                    </a>
                @endforeach
            </div>
        </aside>
    </div>
</section>

<script>
    (() => {
        const trackUrl = @json(route('learn.lesson.track', ['lessonId' => $lesson->id], false));
        const csrf = @json(csrf_token());

        let pendingSeconds = 0;
        let liveTotal = {{ (int) ($lessonProgress->time_spent ?? 0) }};
        const liveEl = document.getElementById('live-time');
        const completeInput = document.getElementById('complete-seconds');

        function tick() {
            pendingSeconds += 1;
            liveTotal += 1;
            if (liveEl) liveEl.textContent = String(liveTotal);
            if (completeInput) completeInput.value = String(pendingSeconds);
        }

        async function flush(useBeacon = false) {
            if (pendingSeconds <= 0) return;

            const seconds = pendingSeconds;
            pendingSeconds = 0;

            const payload = `_token=${encodeURIComponent(csrf)}&seconds=${seconds}`;

            if (useBeacon && navigator.sendBeacon) {
                const blob = new Blob([payload], { type: 'application/x-www-form-urlencoded' });
                navigator.sendBeacon(trackUrl, blob);
                return;
            }

            try {
                await fetch(trackUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: payload,
                    keepalive: true,
                });
            } catch (e) {
                // Best effort tracking
            }
        }

        setInterval(tick, 1000);
        setInterval(() => flush(false), 15000);

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) flush(true);
        });

        window.addEventListener('beforeunload', () => flush(true));
    })();
</script>
@endsection
