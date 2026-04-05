@extends('layouts.app')

@section('title', ($lesson->title ?? 'Lesson') . ' - Learning Path')

@push('styles')
<style>
  .ll-wrap { max-width: 1150px; margin: 28px auto; padding: 0 20px 48px; display: flex; flex-direction: column; gap: 14px; }

  /* ── Back ── */
  .ll-back {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; font-weight: 600; color: #4285F4; text-decoration: none;
    background: #fff; border: 1px solid #e8e9eb; border-radius: 10px;
    padding: 7px 13px; transition: all .15s; align-self: flex-start;
  }
  .ll-back:hover { background: #eff6ff; border-color: #bfdbfe; transform: translateX(-2px); }

  /* ── Main grid ── */
  .ll-grid { display: grid; grid-template-columns: 1fr 300px; gap: 16px; align-items: start; }
  @media (max-width: 820px) { .ll-grid { grid-template-columns: 1fr; } }

  /* ── Lesson card ── */
  .ll-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .ll-card-stripe { height: 4px; background: linear-gradient(90deg,#4285F4,#34A853); }
  .ll-card-head { padding: 24px 28px 20px; border-bottom: 1px solid #f3f4f6; }

  /* breadcrumb */
  .ll-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #aaa; flex-wrap: wrap; margin-bottom: 12px; }
  .ll-breadcrumb a { color: #4285F4; text-decoration: none; font-weight: 600; }
  .ll-breadcrumb a:hover { text-decoration: underline; }
  .ll-breadcrumb span { color: #ccc; }

  .ll-title-row { display: flex; align-items: flex-start; gap: 14px; flex-wrap: wrap; }
  .ll-lesson-icon {
    width: 46px; height: 46px; border-radius: 14px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center; font-size: 22px;
    box-shadow: 0 4px 12px rgba(66,133,244,.28);
  }
  .ll-title-block { flex: 1; min-width: 0; }
  .ll-title-block h1 { font-size: 20px; font-weight: 800; color: #1a1a1a; margin: 0 0 8px; line-height: 1.35; }
  .ll-meta-pills { display: flex; gap: 7px; flex-wrap: wrap; }
  .ll-pill {
    display: flex; align-items: center; gap: 5px;
    background: #f5f6f8; border: 1px solid #e8e9eb;
    border-radius: 20px; padding: 4px 11px;
    font-size: 11.5px; font-weight: 600; color: #666;
  }
  .type-video    { background:#fef2f2; border-color:#fecaca; color:#dc2626; }
  .type-quiz     { background:#faf5ff; border-color:#e9d5ff; color:#7c3aed; }
  .type-exercise { background:#fffbeb; border-color:#fde68a; color:#d97706; }
  .type-text     { background:#eff6ff; border-color:#bfdbfe; color:#4285F4; }

  /* ── Timer bar ── */
  .ll-timer {
    margin: 0 28px 20px; padding: 12px 16px;
    background: #f9fafb; border: 1px solid #eaeaea; border-radius: 14px;
    display: flex; align-items: center; gap: 12px;
  }
  .ll-timer-icon { font-size: 20px; flex-shrink: 0; }
  .ll-timer-label { font-size: 12.5px; color: #888; font-weight: 500; }
  .ll-timer-val   { font-size: 16px; font-weight: 800; color: #1a1a1a; margin-left: auto; font-variant-numeric: tabular-nums; }

  /* ── Video link ── */
  .ll-video-link {
    margin: 0 28px 18px; display: flex; align-items: center; gap: 10px;
    padding: 14px 18px; background: #fef2f2; border: 1px solid #fecaca;
    border-radius: 14px; text-decoration: none; transition: background .15s;
  }
  .ll-video-link:hover { background: #fee2e2; }
  .ll-video-link-icon { font-size: 24px; flex-shrink: 0; }
  .ll-video-link-text { flex: 1; }
  .ll-video-link-title { font-size: 13.5px; font-weight: 700; color: #1a1a1a; }
  .ll-video-link-sub   { font-size: 12px; color: #ef4444; margin-top: 2px; }
  .ll-video-link-arrow { font-size: 18px; color: #ef4444; flex-shrink: 0; }

  /* ── Content body ── */
  .ll-content {
    padding: 6px 28px 24px; font-size: 15px; line-height: 1.8; color: #374151;
  }
  .ll-content h1,.ll-content h2,.ll-content h3 { color: #1a1a1a; font-weight: 800; margin: 1.4em 0 .6em; }
  .ll-content h2 { font-size: 18px; border-bottom: 2px solid #f0f0f0; padding-bottom: 8px; }
  .ll-content h3 { font-size: 16px; }
  .ll-content p  { margin: 0 0 1em; }
  .ll-content a  { color: #4285F4; }
  .ll-content ul,.ll-content ol { margin: 0 0 1em 1.4em; }
  .ll-content li { margin-bottom: .4em; }
  .ll-content code {
    background: #eff6ff; color: #4285F4; border-radius: 5px;
    padding: 2px 6px; font-size: 13.5px; font-family: 'Fira Code', monospace;
  }
  .ll-content pre {
    background: #1e293b; color: #e2e8f0; border-radius: 14px;
    padding: 18px 20px; overflow-x: auto; font-size: 13.5px;
    margin: 0 0 1em; line-height: 1.7;
  }
  .ll-content pre code { background: none; color: inherit; padding: 0; font-size: inherit; }
  .ll-content blockquote {
    border-left: 4px solid #4285F4; background: #eff6ff;
    margin: 0 0 1em; padding: 12px 18px; border-radius: 0 12px 12px 0; color: #1e40af;
  }
  .ll-content img { max-width: 100%; border-radius: 12px; margin: .5em 0; }
  .ll-content table { width: 100%; border-collapse: collapse; margin: 0 0 1em; font-size: 14px; }
  .ll-content th { background: #f5f6f8; text-align: left; padding: 10px 14px; font-weight: 700; border: 1px solid #eaeaea; }
  .ll-content td { padding: 10px 14px; border: 1px solid #f0f0f0; }

  /* ── Complete button ── */
  .ll-complete-area {
    padding: 18px 28px; border-top: 1px solid #f3f4f6;
    display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
  }
  .ll-complete-btn {
    display: inline-flex; align-items: center; gap: 9px;
    padding: 13px 26px; border: none; border-radius: 14px; cursor: pointer;
    background: linear-gradient(135deg,#4285F4,#34A853); color: #fff;
    font-size: 14px; font-weight: 700; font-family: inherit;
    box-shadow: 0 4px 14px rgba(66,133,244,.35); transition: all .15s;
  }
  .ll-complete-btn:hover { transform: translateY(-2px); box-shadow: 0 7px 20px rgba(66,133,244,.4); }
  .ll-complete-btn:disabled { opacity: .55; cursor: not-allowed; transform: none; box-shadow: none; }
  .ll-complete-hint { font-size: 12px; color: #bbb; }

  /* ── Sidebar ── */
  .ll-sidebar { display: flex; flex-direction: column; gap: 14px; }
  .ll-sidebar-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 18px;
    overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .ll-sidebar-head {
    padding: 14px 18px; border-bottom: 1px solid #f3f4f6;
    display: flex; align-items: center; justify-content: space-between;
  }
  .ll-sidebar-head h3 { font-size: 13.5px; font-weight: 800; color: #1a1a1a; margin: 0; }
  .ll-lesson-count { font-size: 11.5px; font-weight: 700; color: #4285F4;
    background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 20px; padding: 2px 9px; }

  .ll-lesson-links { padding: 8px; display: flex; flex-direction: column; gap: 4px; }
  .ll-lesson-link {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 12px; text-decoration: none;
    border: 1.5px solid transparent; transition: all .13s;
  }
  .ll-lesson-link:hover { background: #f5f6f8; }
  .ll-lesson-link.active { background: #eff6ff; border-color: #bfdbfe; }
  .ll-lesson-link.completed { background: #f0fdf4; border-color: #bbf7d0; }
  .ll-lesson-num {
    width: 26px; height: 26px; border-radius: 8px; flex-shrink: 0;
    background: #f3f4f6; border: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 800; color: #aaa;
  }
  .ll-lesson-link.active .ll-lesson-num {
    background: linear-gradient(135deg,#4285F4,#34A853);
    border-color: transparent; color: #fff;
  }
  .ll-lesson-link.completed .ll-lesson-num {
    background: #22c55e; border-color: #22c55e; color: #fff;
  }
  .ll-lesson-link.active.completed .ll-lesson-num {
    background: linear-gradient(135deg,#16a34a,#22c55e);
  }
  .ll-lesson-link-body { flex: 1; min-width: 0; }
  .ll-lesson-link-num  { font-size: 10.5px; color: #bbb; font-weight: 600; }
  .ll-lesson-link-title{ font-size: 13px; font-weight: 600; color: #1a1a1a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .ll-lesson-link.active .ll-lesson-link-title { color: #4285F4; }
  .ll-lesson-link.completed .ll-lesson-link-title { color: #166534; }
  .ll-lesson-status {
    display: inline-flex; align-items: center; gap: 4px; margin-top: 4px;
    font-size: 10.5px; font-weight: 700; color: #16a34a;
  }

  /* ── Module info card ── */
  .ll-mod-info { padding: 16px 18px; }
  .ll-mod-info-row { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 12px; }
  .ll-mod-info-row:last-child { margin-bottom: 0; }
  .ll-mod-info-icon { font-size: 18px; flex-shrink: 0; margin-top: 1px; }
  .ll-mod-info-label { font-size: 11px; color: #aaa; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }
  .ll-mod-info-val   { font-size: 13.5px; font-weight: 700; color: #1a1a1a; margin-top: 2px; }

  @media (max-width: 640px) {
    .ll-wrap { padding: 0 12px 40px; margin-top: 20px; }
    .ll-card-head { padding: 18px 16px 16px; }
    .ll-content { padding: 6px 16px 20px; }
    .ll-timer { margin: 0 16px 16px; }
    .ll-video-link { margin: 0 16px 14px; }
    .ll-complete-area { padding: 14px 16px; }
  }
</style>
@endpush

@section('content')

@php
  $type      = strtolower($lesson->lesson_type ?? 'text');
  $typeClass = match($type) { 'video'=>'type-video','quiz'=>'type-quiz','exercise'=>'type-exercise',default=>'type-text' };
  $typeIcon  = match($type) { 'video'=>'🎬','quiz'=>'🧩','exercise'=>'⚙️',default=>'📄' };
  $typeLabel = ucfirst($type);
  $timeSpent = (int)($lessonProgress->time_spent ?? 0);
@endphp

<div class="ll-wrap">

  {{-- ── Back link ── --}}
  <a href="{{ route('learn.course', ['id' => $course->id], false) }}" class="ll-back">
    ← Back to {{ $course->title }}
  </a>

  <div class="ll-grid">

    {{-- ══ MAIN CONTENT ══ --}}
    <div class="ll-card">
      <div class="ll-card-stripe"></div>

      {{-- Head --}}
      <div class="ll-card-head">
        {{-- Breadcrumb --}}
        <div class="ll-breadcrumb">
          <a href="{{ route('learn', [], false) }}">Learning Path</a>
          <span>/</span>
          <a href="{{ route('learn.course', ['id' => $course->id], false) }}">{{ $course->title }}</a>
          <span>/</span>
          <span>Module {{ $module->module_number }}: {{ $module->title }}</span>
        </div>

        {{-- Title + meta --}}
        <div class="ll-title-row">
          <div class="ll-lesson-icon">{{ $typeIcon }}</div>
          <div class="ll-title-block">
            <h1>Lesson {{ $lesson->lesson_number }}: {{ $lesson->title }}</h1>
            <div class="ll-meta-pills">
              <span class="ll-pill {{ $typeClass }}">{{ $typeIcon }} {{ $typeLabel }}</span>
              @if($lesson->duration)
                <span class="ll-pill">⏱️ {{ $lesson->duration }} min</span>
              @endif
              <span class="ll-pill">📂 Module {{ $module->module_number }}</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Timer --}}
      <div class="ll-timer">
        <span class="ll-timer-icon">⏳</span>
        <div>
          <div class="ll-timer-label">Time spent on this lesson</div>
        </div>
        <div class="ll-timer-val">
          <span id="live-time-fmt">{{ gmdate('i:s', $timeSpent) }}</span>
        </div>
      </div>

      {{-- Video link --}}
      @if(!empty($lesson->video_url))
        <a href="{{ $lesson->video_url }}" target="_blank" rel="noopener noreferrer" class="ll-video-link">
          <span class="ll-video-link-icon">🎬</span>
          <div class="ll-video-link-text">
            <div class="ll-video-link-title">Watch Video Lesson</div>
            <div class="ll-video-link-sub">Opens in a new tab</div>
          </div>
          <span class="ll-video-link-arrow">↗</span>
        </a>
      @endif

      {{-- Content --}}
      <div class="ll-content">
        {!! \Illuminate\Support\Str::markdown($lesson->content ?? '', ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
      </div>

      {{-- Complete form --}}
      <form method="POST" action="{{ route('learn.lesson.complete', ['courseId' => $course->id, 'moduleId' => $module->id, 'lessonId' => $lesson->id], false) }}">
        @csrf
        <input type="hidden" id="complete-seconds" name="seconds" value="0">
        <div class="ll-complete-area">
          <button type="submit" class="ll-complete-btn" id="completeBtn">
            @if($nextLesson)
              <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Mark Complete &amp; Next Lesson
            @else
              <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"/>
              </svg>
              Mark Complete
            @endif
          </button>
          <span class="ll-complete-hint">Your progress is saved automatically</span>
        </div>
      </form>
    </div>

    {{-- ══ SIDEBAR ══ --}}
    <div class="ll-sidebar">

      {{-- Module info --}}
      <div class="ll-sidebar-card">
        <div class="ll-sidebar-head">
          <h3>Module Info</h3>
        </div>
        <div class="ll-mod-info">
          <div class="ll-mod-info-row">
            <span class="ll-mod-info-icon">📂</span>
            <div>
              <div class="ll-mod-info-label">Module</div>
              <div class="ll-mod-info-val">{{ $module->module_number }}. {{ $module->title }}</div>
            </div>
          </div>
          <div class="ll-mod-info-row">
            <span class="ll-mod-info-icon">📘</span>
            <div>
              <div class="ll-mod-info-label">Course</div>
              <div class="ll-mod-info-val">{{ $course->title }}</div>
            </div>
          </div>
          @if($course->department)
          <div class="ll-mod-info-row">
            <span class="ll-mod-info-icon">🏛️</span>
            <div>
              <div class="ll-mod-info-label">Department</div>
              <div class="ll-mod-info-val">{{ $course->department->code ?? $course->department->name }}</div>
            </div>
          </div>
          @endif
        </div>
      </div>

      {{-- Lesson list --}}
      <div class="ll-sidebar-card">
        <div class="ll-sidebar-head">
          <h3>Lessons</h3>
          <span class="ll-lesson-count">{{ $moduleLessons->count() }}</span>
        </div>
        <div class="ll-lesson-links">
          @foreach($moduleLessons as $ml)
            @php
              $isActive = (int)$ml->id === (int)$lesson->id;
              $mlType   = strtolower($ml->lesson_type ?? 'text');
              $mlIcon   = match($mlType){ 'video'=>'🎬','quiz'=>'🧩','exercise'=>'⚙️',default=>'📄' };
              $mlProgress = $lessonStatuses->get($ml->id);
              $isCompleted = ($mlProgress->status ?? null) === 'completed';
            @endphp
            <a href="{{ route('learn.lesson', ['courseId' => $course->id, 'moduleId' => $module->id, 'lessonId' => $ml->id], false) }}"
               class="ll-lesson-link {{ $isActive ? 'active' : '' }} {{ $isCompleted ? 'completed' : '' }}">
              <div class="ll-lesson-num">{{ $isCompleted ? '✓' : $ml->lesson_number }}</div>
              <div class="ll-lesson-link-body">
                <div class="ll-lesson-link-num">{{ $mlIcon }} Lesson {{ $ml->lesson_number }}</div>
                <div class="ll-lesson-link-title">{{ $ml->title }}</div>
                @if($isCompleted)
                  <div class="ll-lesson-status">Completed</div>
                @endif
              </div>
            </a>
          @endforeach
        </div>
      </div>

    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
(() => {
  const trackUrl = @json(route('learn.lesson.track', ['lessonId' => $lesson->id], false));
  const csrf     = @json(csrf_token());

  let pending  = 0;
  let total    = {{ (int)($lessonProgress->time_spent ?? 0) }};
  const fmtEl  = document.getElementById('live-time-fmt');
  const hidEl  = document.getElementById('complete-seconds');

  function fmt(s) {
    const m = String(Math.floor(s / 60)).padStart(2,'0');
    const sec = String(s % 60).padStart(2,'0');
    return m + ':' + sec;
  }

  function tick() {
    pending++; total++;
    if (fmtEl) fmtEl.textContent = fmt(total);
    if (hidEl) hidEl.value = String(pending);
  }

  async function flush(beacon = false) {
    if (pending <= 0) return;
    const secs = pending; pending = 0;
    const body = `_token=${encodeURIComponent(csrf)}&seconds=${secs}`;
    if (beacon && navigator.sendBeacon) {
      navigator.sendBeacon(trackUrl, new Blob([body], { type: 'application/x-www-form-urlencoded' }));
      return;
    }
    try {
      await fetch(trackUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': csrf },
        body, keepalive: true,
      });
    } catch {}
  }

  setInterval(tick, 1000);
  setInterval(() => flush(false), 15000);
  document.addEventListener('visibilitychange', () => { if (document.hidden) flush(true); });
  window.addEventListener('beforeunload', () => flush(true));

  // Complete button loading state
  document.querySelector('form')?.addEventListener('submit', () => {
    const btn = document.getElementById('completeBtn');
    if (btn) { btn.disabled = true; btn.style.opacity = '.7'; }
  });
})();
</script>
@endpush
