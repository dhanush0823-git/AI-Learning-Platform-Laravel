@extends('layouts.app')

@section('title', ($course->title ?? 'Course') . ' - Learning Path')

@push('styles')
<style>
  .lc-wrap { max-width: 1000px; margin: 32px auto; padding: 0 20px 48px; display: flex; flex-direction: column; gap: 16px; }

  /* ── Back link ── */
  .lc-back {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; font-weight: 600; color: #4285F4; text-decoration: none;
    background: #fff; border: 1px solid #e8e9eb; border-radius: 10px;
    padding: 7px 13px; transition: all .15s; align-self: flex-start;
  }
  .lc-back:hover { background: #eff6ff; border-color: #bfdbfe; transform: translateX(-2px); }

  /* ── Course hero ── */
  .lc-hero {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .lc-hero-stripe { height: 4px; background: linear-gradient(90deg,#4285F4,#34A853); }
  .lc-hero-body   { padding: 26px 28px; display: flex; gap: 20px; align-items: flex-start; flex-wrap: wrap; }
  .lc-hero-icon {
    width: 58px; height: 58px; border-radius: 18px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center; font-size: 28px;
    box-shadow: 0 6px 18px rgba(66,133,244,.3);
  }
  .lc-hero-info { flex: 1; min-width: 0; }
  .lc-hero-info h1 { font-size: 22px; font-weight: 800; color: #1a1a1a; margin: 0 0 6px; }
  .lc-hero-info p  { font-size: 14px; color: #888; line-height: 1.6; margin: 0 0 16px; }
  .lc-hero-chips { display: flex; gap: 8px; flex-wrap: wrap; }
  .lc-chip {
    display: flex; align-items: center; gap: 5px;
    background: #f5f6f8; border: 1px solid #e8e9eb; border-radius: 20px;
    padding: 5px 12px; font-size: 12px; font-weight: 600; color: #555;
  }

  /* ── Overall progress ── */
  .lc-progress {
    background: #fff; border: 1px solid #eaeaea; border-radius: 16px;
    padding: 18px 22px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .lc-prog-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
  .lc-prog-label { font-size: 13px; font-weight: 700; color: #555; }
  .lc-prog-pct   { font-size: 22px; font-weight: 800; color: #4285F4; }
  .lc-prog-bar   { height: 9px; background: #f0f0f0; border-radius: 99px; overflow: hidden; }
  .lc-prog-fill  { height: 100%; border-radius: 99px; background: linear-gradient(90deg,#4285F4,#34A853); }
  .lc-prog-sub   { font-size: 12px; color: #bbb; margin-top: 8px; }

  /* ── Section title ── */
  .lc-section-head {
    display: flex; align-items: center; gap: 10px; margin: 4px 0 0;
  }
  .lc-section-head h2 { font-size: 16px; font-weight: 800; color: #1a1a1a; margin: 0; }
  .lc-count-badge {
    font-size: 11.5px; font-weight: 700; background: #eff6ff; color: #4285F4;
    border: 1px solid #bfdbfe; border-radius: 20px; padding: 2px 10px;
  }

  /* ── Module card ── */
  .mod-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04);
    transition: box-shadow .2s;
  }
  .mod-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.08); }

  .mod-header {
    padding: 18px 22px; display: flex; align-items: center;
    justify-content: space-between; gap: 14px; flex-wrap: wrap;
    border-bottom: 1px solid #f3f4f6;
  }
  .mod-header-left { display: flex; align-items: center; gap: 14px; flex: 1; min-width: 0; }
  .mod-num {
    width: 38px; height: 38px; border-radius: 12px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 14px; font-weight: 800;
    box-shadow: 0 3px 8px rgba(66,133,244,.28);
  }
  .mod-title-block { flex: 1; min-width: 0; }
  .mod-title { font-size: 15px; font-weight: 800; color: #1a1a1a; margin: 0 0 3px; }
  .mod-sub   { font-size: 12px; color: #aaa; }
  .mod-start-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: 12px;
    background: linear-gradient(135deg,#4285F4,#34A853); color: #fff;
    font-size: 13px; font-weight: 700; text-decoration: none;
    box-shadow: 0 3px 10px rgba(66,133,244,.3); transition: all .15s; flex-shrink: 0;
  }
  .mod-start-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(66,133,244,.4); }

  /* ── Lesson rows ── */
  .lesson-list { padding: 6px 0; }
  .lesson-row {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 14px 22px; border-bottom: 1px solid #f7f7f7;
    transition: background .13s;
  }
  .lesson-row:last-child { border-bottom: none; }
  .lesson-row:hover { background: #fafbff; }

  .lesson-num {
    width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
    background: #f3f4f6; border: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    font-size: 11.5px; font-weight: 800; color: #888; margin-top: 1px;
  }
  .lesson-body { flex: 1; min-width: 0; }
  .lesson-link {
    font-size: 14px; font-weight: 600; color: #1a1a1a; text-decoration: none;
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    transition: color .13s;
  }
  .lesson-link:hover { color: #4285F4; }

  .lesson-type-badge {
    font-size: 10.5px; font-weight: 700; padding: 2px 8px; border-radius: 6px;
    text-transform: capitalize; flex-shrink: 0;
  }
  .type-video   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
  .type-text    { background: #eff6ff; color: #4285F4; border: 1px solid #bfdbfe; }
  .type-quiz    { background: #faf5ff; color: #7c3aed; border: 1px solid #e9d5ff; }
  .type-exercise{ background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
  .type-default { background: #f3f4f6; color: #6b7280; border: 1px solid #e5e7eb; }

  .lesson-content {
    margin-top: 10px; font-size: 13.5px; color: #555; line-height: 1.7;
    background: #f9fafb; border: 1px solid #f0f0f0; border-radius: 12px;
    padding: 12px 16px;
  }
  .lesson-content p { margin: 0 0 8px; }
  .lesson-content p:last-child { margin: 0; }
  .lesson-content code { background: #eff6ff; color: #4285F4; border-radius: 4px; padding: 1px 5px; font-size: 12.5px; }
  .lesson-content pre  { background: #1e293b; color: #e2e8f0; border-radius: 10px; padding: 14px 16px; overflow-x: auto; font-size: 13px; }

  /* ── Empty module ── */
  .mod-empty { padding: 32px; text-align: center; color: #bbb; font-size: 13px; }

  @media (max-width: 640px) {
    .lc-wrap { padding: 0 12px 40px; margin-top: 20px; }
    .lc-hero-body { padding: 18px; }
    .lc-hero-info h1 { font-size: 18px; }
    .mod-header { padding: 14px 16px; }
    .lesson-row { padding: 12px 14px; }
  }
</style>
@endpush

@section('content')

@php
  $moduleCount = $course->modules->count();
  $lessonCount = $course->modules->sum(fn($m) => $m->lessons->count());
  $level       = ucfirst($course->level ?? 'Beginner');
  $dept        = $course->department->code ?? ($course->department->name ?? null);
  $overallProg = (int) ($course->pivot->progress ?? 0);
@endphp

<div class="lc-wrap">

  {{-- ── Back ── --}}
  <a href="{{ route('learn', [], false) }}" class="lc-back">← Back to Learning Path</a>

  {{-- ── Hero ── --}}
  <div class="lc-hero">
    <div class="lc-hero-stripe"></div>
    <div class="lc-hero-body">
      <div class="lc-hero-icon">📘</div>
      <div class="lc-hero-info">
        <h1>{{ $course->title }}</h1>
        @if($course->description)
          <p>{{ $course->description }}</p>
        @endif
        <div class="lc-hero-chips">
          @if($dept)
            <span class="lc-chip">🏛️ {{ $dept }}</span>
          @endif
          <span class="lc-chip">📂 {{ $moduleCount }} Modules</span>
          <span class="lc-chip">📄 {{ $lessonCount }} Lessons</span>
          <span class="lc-chip" style="color:
            @if($level==='Advanced') #dc2626; background:#fef2f2; border-color:#fecaca;
            @elseif($level==='Intermediate') #d97706; background:#fffbeb; border-color:#fde68a;
            @else #16a34a; background:#f0fdf4; border-color:#bbf7d0;
            @endif">
            🎯 {{ $level }}
          </span>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Course progress ── --}}
  <div class="lc-progress">
    <div class="lc-prog-top">
      <span class="lc-prog-label">Course Progress</span>
      <span class="lc-prog-pct">{{ $overallProg }}%</span>
    </div>
    <div class="lc-prog-bar">
      <div class="lc-prog-fill" style="width:{{ $overallProg }}%"></div>
    </div>
    <p class="lc-prog-sub">
      @if($overallProg >= 100) 🎉 Course complete! Great work.
      @elseif($overallProg > 0) Keep going — you're {{ $overallProg }}% through!
      @else Start your first lesson below to begin. 🚀
      @endif
    </p>
  </div>

  {{-- ── Section heading ── --}}
  <div class="lc-section-head">
    <h2>Modules &amp; Lessons</h2>
    <span class="lc-count-badge">{{ $moduleCount }} modules · {{ $lessonCount }} lessons</span>
  </div>

  {{-- ── Modules ── --}}
  @foreach($course->modules as $module)
    @php
      $lCount = $module->lessons->count();
    @endphp
    <div class="mod-card">

      {{-- Module header --}}
      <div class="mod-header">
        <div class="mod-header-left">
          <div class="mod-num">{{ $module->module_number }}</div>
          <div class="mod-title-block">
            <p class="mod-title">{{ $module->title }}</p>
            <p class="mod-sub">{{ $lCount }} {{ Str::plural('lesson', $lCount) }}</p>
          </div>
        </div>
        @if($module->lessons->isNotEmpty())
          <a href="{{ route('learn.module.start', ['courseId' => $course->id, 'moduleId' => $module->id], false) }}"
             class="mod-start-btn">
            ▶ Start Module
          </a>
        @endif
      </div>

      {{-- Lessons --}}
      @if($module->lessons->isNotEmpty())
        <div class="lesson-list">
          @foreach($module->lessons as $lesson)
            @php
              $type      = strtolower($lesson->lesson_type ?? 'text');
              $typeClass = match($type) {
                'video'    => 'type-video',
                'quiz'     => 'type-quiz',
                'exercise' => 'type-exercise',
                'text'     => 'type-text',
                default    => 'type-default',
              };
              $typeIcon = match($type) {
                'video'    => '🎬',
                'quiz'     => '🧩',
                'exercise' => '⚙️',
                'text'     => '📄',
                default    => '📌',
              };
            @endphp
            <div class="lesson-row">
              <div class="lesson-num">{{ $lesson->lesson_number }}</div>
              <div class="lesson-body">
                <a href="{{ route('learn.lesson', ['courseId' => $course->id, 'moduleId' => $module->id, 'lessonId' => $lesson->id], false) }}"
                   class="lesson-link">
                  {{ $lesson->title }}
                  <span class="lesson-type-badge {{ $typeClass }}">{{ $typeIcon }} {{ ucfirst($type) }}</span>
                </a>
                @if(!empty($lesson->content))
                  <div class="lesson-content">
                    {!! \Illuminate\Support\Str::markdown($lesson->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="mod-empty">📭 No lessons added to this module yet.</div>
      @endif

    </div>
  @endforeach

</div>
@endsection