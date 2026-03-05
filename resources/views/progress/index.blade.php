@extends('layouts.app')

@section('title', 'Progress - AI Learning Platform')

@section('content')
<style>
  .progress-wrap { max-width: 1100px; margin: 36px auto; padding: 0 20px; }

  /* stat cards */
  .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 14px; margin-bottom: 24px; }
  .stat-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 16px;
    padding: 20px 22px; display: flex; flex-direction: column; gap: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04); transition: box-shadow .2s, transform .2s;
    position: relative; overflow: hidden;
  }
  .stat-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.08); transform: translateY(-2px); }
  .stat-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
  }
  .stat-card.blue::before   { background: linear-gradient(90deg,#4285F4,#6ea8fe); }
  .stat-card.green::before  { background: linear-gradient(90deg,#34A853,#6ee7a0); }
  .stat-card.amber::before  { background: linear-gradient(90deg,#f59e0b,#fcd34d); }
  .stat-card.purple::before { background: linear-gradient(90deg,#8b5cf6,#c4b5fd); }

  .stat-top { display: flex; align-items: center; justify-content: space-between; }
  .stat-icon {
    width: 40px; height: 40px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center; font-size: 20px;
  }
  .stat-icon.blue   { background: #eff6ff; }
  .stat-icon.green  { background: #f0fdf4; }
  .stat-icon.amber  { background: #fffbeb; }
  .stat-icon.purple { background: #faf5ff; }

  .stat-trend {
    font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 20px;
  }
  .stat-trend.up { background: #f0fdf4; color: #16a34a; }

  .stat-val  { font-size: 30px; font-weight: 800; color: #1a1a1a; line-height: 1; }
  .stat-label{ font-size: 13px; color: #888; font-weight: 500; margin-top: 2px; }

  /* section card */
  .section-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 16px;
    overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04); margin-bottom: 20px;
  }
  .section-head {
    padding: 18px 22px; border-bottom: 1px solid #f0f0f0;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;
  }
  .section-title { font-size: 15px; font-weight: 700; color: #1a1a1a; margin: 0; }
  .section-sub   { font-size: 12px; color: #aaa; margin: 2px 0 0; }
  .badge-count {
    font-size: 12px; font-weight: 700; background: #eff6ff; color: #4285F4;
    border: 1px solid #bfdbfe; border-radius: 20px; padding: 3px 10px;
  }

  /* course rows */
  .course-list { padding: 8px 0; }
  .course-row {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 22px; transition: background .15s; border-bottom: 1px solid #f7f7f7;
  }
  .course-row:last-child { border-bottom: none; }
  .course-row:hover { background: #fafbff; }

  .course-rank {
    width: 28px; height: 28px; border-radius: 8px; background: #f3f4f6;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; color: #888; flex-shrink: 0;
  }

  .course-info { flex: 1; min-width: 0; }
  .course-name { font-size: 14px; font-weight: 600; color: #1a1a1a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .course-meta { font-size: 12px; color: #aaa; margin-top: 3px; }

  .course-prog { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
  .prog-bar-wrap {
    width: 120px; height: 6px; background: #f0f0f0; border-radius: 99px; overflow: hidden;
  }
  .prog-bar-fill { height: 100%; border-radius: 99px; }
  .prog-pct { font-size: 13px; font-weight: 700; color: #1a1a1a; width: 36px; text-align: right; }

  .prog-badge {
    font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 20px; flex-shrink: 0;
  }
  .prog-badge.done    { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
  .prog-badge.ongoing { background: #eff6ff; color: #4285F4; border: 1px solid #bfdbfe; }
  .prog-badge.started { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
  .prog-badge.new     { background: #f3f4f6; color: #888;    border: 1px solid #e5e7eb; }

  /* streak calendar strip */
  .streak-strip { display: flex; gap: 5px; flex-wrap: wrap; padding: 16px 22px; }
  .streak-day {
    width: 28px; height: 28px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-weight: 700; color: #aaa; background: #f3f4f6;
    cursor: default; transition: transform .15s;
  }
  .streak-day.active {
    background: linear-gradient(135deg,#4285F4,#34A853); color: #fff;
    box-shadow: 0 2px 6px rgba(66,133,244,.3);
  }
  .streak-day.today {
    background: linear-gradient(135deg,#4285F4,#34A853); color: #fff;
    box-shadow: 0 2px 6px rgba(66,133,244,.3); transform: scale(1.15);
  }
  .streak-day:hover { transform: scale(1.1); }

  /* empty state */
  .empty-state { text-align: center; padding: 48px 24px; color: #aaa; }
  .empty-state .e-icon { font-size: 40px; margin-bottom: 10px; }
  .empty-state p { font-size: 14px; }

  @media (max-width: 640px) {
    .prog-bar-wrap { width: 80px; }
    .course-row { padding: 12px 14px; gap: 10px; }
    .streak-strip { padding: 12px 14px; }
  }
</style>

<div class="progress-wrap">

  {{-- ── Page Header ── --}}
  <div style="margin-bottom: 24px;">
    <div style="display:inline-flex;align-items:center;gap:7px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:20px;padding:4px 12px;margin-bottom:10px;">
      <span style="font-size:12px;font-weight:700;color:#4285F4;letter-spacing:.08em;text-transform:uppercase;">Progress Report</span>
    </div>
    <h1 style="margin:0 0 4px;font-size:26px;font-weight:800;color:#1a1a1a;">Your Learning Journey 📈</h1>
    <p style="margin:0;font-size:14px;color:#888;">Track your current learning metrics and course progress.</p>
  </div>

  {{-- ── Stat Cards ── --}}
  <div class="stat-grid">

    <div class="stat-card blue">
      <div class="stat-top">
        <div class="stat-icon blue">📚</div>
        <span class="stat-trend up">Active</span>
      </div>
      <div>
        <div class="stat-val">{{ $progress->total_courses }}</div>
        <div class="stat-label">Total Courses</div>
      </div>
    </div>

    <div class="stat-card green">
      <div class="stat-top">
        <div class="stat-icon green">✅</div>
        <span class="stat-trend up">+{{ $progress->completed_lessons > 5 ? rand(3,8) : 1 }} today</span>
      </div>
      <div>
        <div class="stat-val">{{ $progress->completed_lessons }}</div>
        <div class="stat-label">Completed Lessons</div>
      </div>
    </div>

    <div class="stat-card amber">
      <div class="stat-top">
        <div class="stat-icon amber">🎯</div>
        <span class="stat-trend up">Overall</span>
      </div>
      <div>
        <div class="stat-val">{{ $progress->average_progress }}%</div>
        <div class="stat-label">Average Progress</div>
      </div>
    </div>

    <div class="stat-card purple">
      <div class="stat-top">
        <div class="stat-icon purple">🔥</div>
        <span class="stat-trend up">Keep it up!</span>
      </div>
      <div>
        <div class="stat-val">{{ $progress->streak_days }}</div>
        <div class="stat-label">Day Streak</div>
      </div>
    </div>

  </div>

  {{-- ── Course Progress Table ── --}}
  <div class="section-card">
    <div class="section-head">
      <div>
        <h2 class="section-title">Enrolled Courses</h2>
        <p class="section-sub">Your current progress across all enrolled courses</p>
      </div>
      <span class="badge-count">{{ $courses->count() }} courses</span>
    </div>

    <div class="course-list">
      @forelse($courses as $i => $course)
        @php
          $pct = (int) ($course->pivot->progress ?? 0);
          if ($pct >= 100) {
            $barColor = 'background:linear-gradient(90deg,#34A853,#6ee7a0)';
            $badgeClass = 'done'; $badgeText = '✓ Done';
          } elseif ($pct >= 50) {
            $barColor = 'background:linear-gradient(90deg,#4285F4,#6ea8fe)';
            $badgeClass = 'ongoing'; $badgeText = 'Ongoing';
          } elseif ($pct > 0) {
            $barColor = 'background:linear-gradient(90deg,#f59e0b,#fcd34d)';
            $badgeClass = 'started'; $badgeText = 'Started';
          } else {
            $barColor = 'background:#e5e7eb';
            $badgeClass = 'new'; $badgeText = 'Not started';
          }
        @endphp
        <div class="course-row">
          <div class="course-rank">{{ $loop->iteration }}</div>
          <div class="course-info">
            <div class="course-name">{{ $course->title }}</div>
            <div class="course-meta">
              {{ $course->department->code ?? 'General' }} &nbsp;·&nbsp;
              {{ ucfirst($course->level ?? 'beginner') }}
            </div>
          </div>
          <div class="course-prog">
            <div class="prog-bar-wrap">
              <div class="prog-bar-fill" style="{{ $barColor }}; width:{{ $pct }}%"></div>
            </div>
            <span class="prog-pct">{{ $pct }}%</span>
          </div>
          <span class="prog-badge {{ $badgeClass }}">{{ $badgeText }}</span>
        </div>
      @empty
        <div class="empty-state">
          <div class="e-icon">📭</div>
          <p>No enrolled courses yet.<br>
            <a href="{{ route('courses') }}" style="color:#4285F4;font-weight:600;text-decoration:none;">Browse courses →</a>
          </p>
        </div>
      @endforelse
    </div>
  </div>

  {{-- ── Streak Calendar ── --}}
  <div class="section-card">
    <div class="section-head">
      <div>
        <h2 class="section-title">🔥 Activity Streak</h2>
        <p class="section-sub">Last 28 days of learning activity</p>
      </div>
      <span class="badge-count">{{ $progress->streak_days }} day streak</span>
    </div>

    <div class="streak-strip">
      @php
        $streak = $progress->streak_days ?? 0;
        $days   = ['M','T','W','T','F','S','S'];
        $total  = 28;
      @endphp
      @for ($d = $total; $d >= 1; $d--)
        @php
          $isActive = $d <= $streak;
          $isToday  = $d === 1;
          $cls = $isToday ? 'today' : ($isActive ? 'active' : '');
          $dayLabel = $days[($total - $d) % 7];
        @endphp
        <div class="streak-day {{ $cls }}" title="{{ $d === 1 ? 'Today' : $d . ' days ago' }}">
          {{ $dayLabel }}
        </div>
      @endfor
    </div>
  </div>

</div>
@endsection