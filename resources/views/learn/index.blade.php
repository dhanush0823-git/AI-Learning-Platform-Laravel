@extends('layouts.app')

@section('title', 'Learning Path - AI Learning Platform')

@push('styles')
<style>
  .lp-wrap { max-width: 1100px; margin: 32px auto; padding: 0 20px 48px; display: flex; flex-direction: column; gap: 20px; }

  /* ── Header ── */
  .lp-header {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    padding: 22px 26px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
    display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
  }
  .lp-header-left { display: flex; align-items: center; gap: 14px; }
  .lp-icon {
    width: 50px; height: 50px; border-radius: 16px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center; font-size: 26px;
    box-shadow: 0 4px 14px rgba(66,133,244,.3);
  }
  .lp-header h1 { font-size: 20px; font-weight: 800; color: #1a1a1a; margin: 0 0 4px; }
  .lp-header p  { font-size: 13px; color: #888; margin: 0; }
  .lp-stats { display: flex; gap: 8px; flex-wrap: wrap; }
  .lp-stat-pill {
    display: flex; align-items: center; gap: 6px;
    background: #f5f6f8; border: 1px solid #e8e9eb; border-radius: 20px;
    padding: 6px 13px; font-size: 12px; font-weight: 600; color: #555;
  }

  /* ── Overall progress bar ── */
  .lp-overall {
    background: #fff; border: 1px solid #eaeaea; border-radius: 16px;
    padding: 18px 22px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .lp-overall-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
  .lp-overall-label { font-size: 13px; font-weight: 700; color: #555; }
  .lp-overall-pct   { font-size: 22px; font-weight: 800; color: #4285F4; }
  .lp-bar { height: 10px; background: #f0f0f0; border-radius: 99px; overflow: hidden; }
  .lp-bar-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg,#4285F4,#34A853); transition: width .6s ease; }
  .lp-overall-sub { font-size: 12px; color: #bbb; margin-top: 8px; }

  /* ── Grid ── */
  .lp-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }

  /* ── Course card ── */
  .lp-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    padding: 22px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
    display: flex; flex-direction: column; gap: 14px;
    transition: box-shadow .2s, transform .2s; position: relative; overflow: hidden;
  }
  .lp-card:hover { box-shadow: 0 12px 32px rgba(0,0,0,.10); transform: translateY(-3px); }
  .lp-card-accent { position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg,#4285F4,#34A853); }

  /* level colour variants */
  .lp-card.beginner  .lp-card-accent { background: linear-gradient(90deg,#34A853,#6ee7a0); }
  .lp-card.intermediate .lp-card-accent { background: linear-gradient(90deg,#f59e0b,#fcd34d); }
  .lp-card.advanced  .lp-card-accent { background: linear-gradient(90deg,#ef4444,#fca5a5); }

  .lp-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
  .lp-card-icon {
    width: 42px; height: 42px; border-radius: 13px; flex-shrink: 0;
    background: linear-gradient(135deg,#eff6ff,#f0fdf4);
    border: 1px solid #e0e7ff;
    display: flex; align-items: center; justify-content: center; font-size: 22px;
  }
  .lp-level-badge {
    font-size: 10.5px; font-weight: 800; padding: 3px 9px; border-radius: 20px;
    text-transform: capitalize; letter-spacing: .04em; flex-shrink: 0;
  }
  .badge-beginner    { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
  .badge-intermediate{ background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
  .badge-advanced    { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
  .badge-default     { background: #eff6ff; color: #4285F4; border: 1px solid #bfdbfe; }

  .lp-card h3 { font-size: 15px; font-weight: 800; color: #1a1a1a; margin: 0; line-height: 1.4; }
  .lp-card-desc { font-size: 13px; color: #888; line-height: 1.6; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

  /* ── Progress section ── */
  .lp-card-progress { display: flex; flex-direction: column; gap: 7px; }
  .lp-card-prog-row { display: flex; align-items: center; justify-content: space-between; }
  .lp-card-prog-label { font-size: 12px; font-weight: 600; color: #888; }
  .lp-card-pct { font-size: 14px; font-weight: 800; color: #1a1a1a; }
  .lp-card-bar { height: 7px; background: #f0f0f0; border-radius: 99px; overflow: hidden; }
  .lp-card-bar-fill { height: 100%; border-radius: 99px; transition: width .5s ease; }
  .fill-done   { background: linear-gradient(90deg,#34A853,#6ee7a0); }
  .fill-mid    { background: linear-gradient(90deg,#4285F4,#6ea8fe); }
  .fill-low    { background: linear-gradient(90deg,#f59e0b,#fcd34d); }
  .fill-none   { background: #e5e7eb; }

  /* ── Dept + meta chips ── */
  .lp-card-meta { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
  .lp-chip {
    font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 8px;
    background: #f3f4f6; color: #666; border: 1px solid #e5e7eb;
  }

  /* ── CTA button ── */
  .lp-open-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 11px 18px; border-radius: 13px; border: none; cursor: pointer;
    font-size: 13.5px; font-weight: 700; font-family: inherit; text-decoration: none;
    transition: all .15s; margin-top: auto;
  }
  .lp-open-btn.primary {
    background: linear-gradient(135deg,#4285F4,#34A853); color: #fff;
    box-shadow: 0 4px 12px rgba(66,133,244,.3);
  }
  .lp-open-btn.primary:hover { transform: translateY(-1px); box-shadow: 0 7px 18px rgba(66,133,244,.4); }
  .lp-open-btn.done {
    background: #f0fdf4; color: #16a34a; border: 1.5px solid #bbf7d0;
  }
  .lp-open-btn.done:hover { background: #dcfce7; }

  /* ── Empty state ── */
  .lp-empty {
    grid-column: 1 / -1; background: #fff; border: 1px solid #eaeaea;
    border-radius: 20px; padding: 64px 24px; text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .lp-empty-icon { font-size: 52px; margin-bottom: 16px; }
  .lp-empty h3   { font-size: 17px; font-weight: 800; color: #333; margin: 0 0 8px; }
  .lp-empty p    { font-size: 14px; color: #aaa; margin: 0 0 20px; }
  .lp-empty-btn  {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px; border-radius: 13px;
    background: linear-gradient(135deg,#4285F4,#34A853); color: #fff;
    font-size: 14px; font-weight: 700; text-decoration: none;
    box-shadow: 0 4px 12px rgba(66,133,244,.3); transition: all .15s;
  }
  .lp-empty-btn:hover { transform: translateY(-2px); box-shadow: 0 7px 18px rgba(66,133,244,.4); }

  @media (max-width: 600px) {
    .lp-wrap { padding: 0 12px 40px; margin-top: 20px; }
    .lp-grid { grid-template-columns: 1fr; }
    .lp-header { padding: 16px 18px; }
  }
</style>
@endpush

@section('content')

@php
  $total    = $courses->count();
  $avgProg  = $total > 0 ? (int) round($courses->avg(fn($c) => $c->pivot->progress ?? 0)) : 0;
  $doneCount = $courses->filter(fn($c) => ($c->pivot->progress ?? 0) >= 100)->count();

  $icons = ['💻','⚡','⚙️','🤖','🏗️','🔬','📐','🧮','🌐','📡'];
@endphp

<div class="lp-wrap">

  {{-- ── Header ── --}}
  <div class="lp-header">
    <div class="lp-header-left">
      <div class="lp-icon">🎯</div>
      <div>
        <h1>Learning Path</h1>
        <p>Continue where you left off — track your progress across all courses</p>
      </div>
    </div>
    @if($total > 0)
    <div class="lp-stats">
      <div class="lp-stat-pill">📚 {{ $total }} Courses</div>
      <div class="lp-stat-pill" style="color:#16a34a;border-color:#bbf7d0;background:#f0fdf4;">✅ {{ $doneCount }} Completed</div>
      <div class="lp-stat-pill" style="color:#4285F4;border-color:#bfdbfe;background:#eff6ff;">🎯 {{ $avgProg }}% Avg</div>
    </div>
    @endif
  </div>

  {{-- ── Overall progress ── --}}
  @if($total > 0)
  <div class="lp-overall">
    <div class="lp-overall-top">
      <span class="lp-overall-label">Overall Learning Progress</span>
      <span class="lp-overall-pct">{{ $avgProg }}%</span>
    </div>
    <div class="lp-bar">
      <div class="lp-bar-fill" style="width:{{ $avgProg }}%"></div>
    </div>
    <p class="lp-overall-sub">{{ $doneCount }} of {{ $total }} courses completed · Keep going! 🚀</p>
  </div>
  @endif

  {{-- ── Cards grid ── --}}
  <div class="lp-grid">

    @forelse($courses as $i => $course)
      @php
        $pct   = (int) ($course->pivot->progress ?? 0);
        $level = strtolower($course->level ?? 'beginner');

        $badgeClass = match($level) {
          'intermediate' => 'badge-intermediate',
          'advanced'     => 'badge-advanced',
          'beginner'     => 'badge-beginner',
          default        => 'badge-default',
        };

        $fillClass = $pct >= 100 ? 'fill-done' : ($pct >= 50 ? 'fill-mid' : ($pct > 0 ? 'fill-low' : 'fill-none'));
        $icon = $icons[$i % count($icons)];

        $btnClass = $pct >= 100 ? 'done' : 'primary';
        $btnText  = $pct >= 100 ? '✓ Review Course' : ($pct > 0 ? 'Continue →' : 'Start Course →');
      @endphp

      <div class="lp-card {{ $level }}">
        <div class="lp-card-accent"></div>

        <div class="lp-card-top">
          <div class="lp-card-icon">{{ $icon }}</div>
          <span class="lp-level-badge {{ $badgeClass }}">{{ ucfirst($level) }}</span>
        </div>

        <div>
          <h3>{{ $course->title }}</h3>
          @if($course->description)
            <p class="lp-card-desc" style="margin-top:6px;">{{ $course->description }}</p>
          @endif
        </div>

        <div class="lp-card-meta">
          @if($course->department)
            <span class="lp-chip">{{ $course->department->code ?? $course->department->name }}</span>
          @endif
          @if($course->modules_count ?? false)
            <span class="lp-chip">📂 {{ $course->modules_count }} modules</span>
          @endif
        </div>

        <div class="lp-card-progress">
          <div class="lp-card-prog-row">
            <span class="lp-card-prog-label">Progress</span>
            <span class="lp-card-pct">{{ $pct }}%</span>
          </div>
          <div class="lp-card-bar">
            <div class="lp-card-bar-fill {{ $fillClass }}" style="width:{{ $pct }}%"></div>
          </div>
        </div>

        <a href="{{ route('learn.course', $course->id) }}" class="lp-open-btn {{ $btnClass }}">
          {{ $btnText }}
        </a>
      </div>

    @empty
      <div class="lp-empty">
        <div class="lp-empty-icon">🗺️</div>
        <h3>No courses yet</h3>
        <p>You haven't enrolled in any courses yet.<br>Browse the catalog to get started.</p>
        <a href="{{ route('courses') }}" class="lp-empty-btn">Browse Courses →</a>
      </div>
    @endforelse

  </div>
</div>
@endsection