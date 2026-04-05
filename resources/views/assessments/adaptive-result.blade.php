@extends('layouts.app')

@section('title', 'Assessment Result')

@push('styles')
<style>
  .ar-wrap { max-width: 860px; margin: 28px auto; padding: 0 20px 48px; display: flex; flex-direction: column; gap: 16px; }

  /* ── Result hero ── */
  .ar-hero {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .ar-hero-stripe { height: 4px; background: linear-gradient(90deg,#4285F4,#34A853); }
  .ar-hero-body { padding: 28px; display: flex; align-items: flex-start; gap: 22px; flex-wrap: wrap; }

  .ar-score-ring {
    width: 110px; height: 110px; border-radius: 50%; flex-shrink: 0;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    position: relative;
  }
  .ar-score-ring svg { position: absolute; top: 0; left: 0; transform: rotate(-90deg); }
  .ar-score-ring-inner { position: relative; z-index: 1; text-align: center; }
  .ar-score-pct  { font-size: 26px; font-weight: 800; color: #1a1a1a; line-height: 1; }
  .ar-score-lbl  { font-size: 11px; color: #aaa; font-weight: 600; margin-top: 2px; }

  .ar-hero-info { flex: 1; min-width: 0; }
  .ar-result-badge {
    display: inline-flex; align-items: center; gap: 7px;
    border-radius: 20px; padding: 6px 14px; font-size: 12px; font-weight: 700;
    margin-bottom: 10px;
  }
  .ar-result-badge.great  { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
  .ar-result-badge.good   { background: #eff6ff; border: 1px solid #bfdbfe; color: #4285F4; }
  .ar-result-badge.ok     { background: #fffbeb; border: 1px solid #fde68a; color: #d97706; }
  .ar-result-badge.low    { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

  .ar-hero-info h1 { font-size: 22px; font-weight: 800; color: #1a1a1a; margin: 0 0 6px; }
  .ar-hero-info p  { font-size: 13.5px; color: #888; margin: 0; line-height: 1.6; }

  /* ── Stat cards ── */
  .ar-stats { display: grid; grid-template-columns: repeat(auto-fit,minmax(170px,1fr)); gap: 12px; }
  .ar-stat {
    background: #fff; border: 1px solid #eaeaea; border-radius: 16px;
    padding: 18px 20px; box-shadow: 0 2px 6px rgba(0,0,0,.04);
    transition: box-shadow .2s, transform .2s; position: relative; overflow: hidden;
  }
  .ar-stat:hover { box-shadow: 0 8px 22px rgba(0,0,0,.08); transform: translateY(-2px); }
  .ar-stat::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; }
  .ar-stat.blue::before   { background: linear-gradient(90deg,#4285F4,#6ea8fe); }
  .ar-stat.green::before  { background: linear-gradient(90deg,#34A853,#6ee7a0); }
  .ar-stat.amber::before  { background: linear-gradient(90deg,#f59e0b,#fcd34d); }
  .ar-stat.purple::before { background: linear-gradient(90deg,#8b5cf6,#c4b5fd); }
  .ar-stat-icon { font-size: 22px; margin-bottom: 10px; }
  .ar-stat-val  { font-size: 26px; font-weight: 800; color: #1a1a1a; line-height: 1; }
  .ar-stat-lbl  { font-size: 12px; color: #aaa; font-weight: 600; margin-top: 5px; }

  /* ── Section card ── */
  .ar-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .ar-card-head {
    padding: 16px 22px; border-bottom: 1px solid #f3f4f6;
    display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
  }
  .ar-card-head h2 { font-size: 15px; font-weight: 800; color: #1a1a1a; margin: 0; }
  .ar-card-head p  { font-size: 12px; color: #aaa; margin: 3px 0 0; }
  .ar-count-pill {
    font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 20px;
    background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;
  }
  .ar-count-pill.ok { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }

  /* ── Weak topic rows ── */
  .ar-topic-list { padding: 8px; display: flex; flex-direction: column; gap: 6px; }
  .ar-topic-row {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 16px; border-radius: 14px; border: 1px solid #f3f4f6;
    background: #fafafa; transition: background .13s;
  }
  .ar-topic-row:hover { background: #f5f6f8; }
  .ar-topic-icon {
    width: 36px; height: 36px; border-radius: 11px; flex-shrink: 0;
    background: #fef2f2; border: 1px solid #fecaca;
    display: flex; align-items: center; justify-content: center; font-size: 18px;
  }
  .ar-topic-info { flex: 1; min-width: 0; }
  .ar-topic-name { font-size: 14px; font-weight: 700; color: #1a1a1a; }
  .ar-topic-sub  { font-size: 12px; color: #aaa; margin-top: 2px; }
  .ar-topic-right { text-align: right; flex-shrink: 0; }
  .ar-topic-acc { font-size: 18px; font-weight: 800; }
  .ar-topic-acc.low { color: #dc2626; }
  .ar-topic-acc.mid { color: #d97706; }
  .ar-topic-bar-wrap { width: 80px; height: 5px; background: #f0f0f0; border-radius: 99px; overflow: hidden; margin-top: 4px; }
  .ar-topic-bar-fill { height: 100%; border-radius: 99px; }
  .fill-low { background: linear-gradient(90deg,#ef4444,#fca5a5); }
  .fill-mid { background: linear-gradient(90deg,#f59e0b,#fcd34d); }

  /* ── Empty state ── */
  .ar-empty { padding: 40px 24px; text-align: center; color: #aaa; }
  .ar-empty-icon { font-size: 38px; margin-bottom: 10px; }
  .ar-empty p { font-size: 13.5px; margin: 0; }

  /* ── CTA buttons ── */
  .ar-cta { display: flex; gap: 10px; flex-wrap: wrap; }
  .ar-btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px; border-radius: 13px; text-decoration: none;
    background: linear-gradient(135deg,#4285F4,#34A853); color: #fff;
    font-size: 14px; font-weight: 700;
    box-shadow: 0 4px 12px rgba(66,133,244,.32); transition: all .15s;
  }
  .ar-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 7px 18px rgba(66,133,244,.4); }
  .ar-btn-outline {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px; border-radius: 13px; text-decoration: none;
    background: #fff; border: 1.5px solid #e5e7eb; color: #374151;
    font-size: 14px; font-weight: 700; transition: all .15s;
  }
  .ar-btn-outline:hover { background: #f5f6f8; border-color: #d0d0d0; }

  @media (max-width: 600px) {
    .ar-wrap { padding: 0 12px 40px; margin-top: 20px; }
    .ar-hero-body { padding: 20px 16px; }
    .ar-score-ring { width: 90px; height: 90px; }
    .ar-score-pct { font-size: 22px; }
  }
</style>
@endpush

@section('content')

@php
  $pct = (int) $percentage;
  $score = (int) $assessment->score;
  $total = (int) $answered;
  $mins  = (int) round(((int) $assessment->time_taken) / 60);

  // Result tier
  if ($pct >= 80) {
    $tier = 'great'; $tierIcon = '🏆'; $tierLabel = 'Excellent Result!';
    $comment = "Outstanding performance! You've demonstrated strong understanding.";
  } elseif ($pct >= 60) {
    $tier = 'good'; $tierIcon = '👍'; $tierLabel = 'Good Job!';
    $comment = "Solid result! A few more rounds and you'll be at the top.";
  } elseif ($pct >= 40) {
    $tier = 'ok'; $tierIcon = '💪'; $tierLabel = 'Keep Practicing';
    $comment = "You're making progress. Focus on the weak topics below.";
  } else {
    $tier = 'low'; $tierIcon = '📚'; $tierLabel = 'Needs Improvement';
    $comment = "Don't worry — review the topics below and try again. You'll get there!";
  }

  // Ring params
  $r = 46; $circ = round(2 * 3.14159 * $r, 1);
  $dash = round($circ * $pct / 100, 1);
  $ringColor = $pct >= 80 ? '#34A853' : ($pct >= 60 ? '#4285F4' : ($pct >= 40 ? '#f59e0b' : '#ef4444'));
@endphp

<div class="ar-wrap">

  {{-- ── Hero / Score ── --}}
  <div class="ar-hero">
    <div class="ar-hero-stripe"></div>
    <div class="ar-hero-body">

      {{-- Circular score ring --}}
      <div class="ar-score-ring">
        <svg width="110" height="110" viewBox="0 0 110 110">
          <circle cx="55" cy="55" r="{{ $r }}" stroke="#f0f0f0" stroke-width="9" fill="none"/>
          <circle cx="55" cy="55" r="{{ $r }}" stroke="{{ $ringColor }}" stroke-width="9" fill="none"
            stroke-linecap="round"
            stroke-dasharray="{{ $dash }} {{ $circ }}"
            style="transition:stroke-dasharray .8s ease;"/>
        </svg>
        <div class="ar-score-ring-inner">
          <div class="ar-score-pct">{{ $pct }}%</div>
          <div class="ar-score-lbl">Score</div>
        </div>
      </div>

      <div class="ar-hero-info">
        <span class="ar-result-badge {{ $tier }}">{{ $tierIcon }} {{ $tierLabel }}</span>
        <h1>Assessment Complete!</h1>
        <p>{{ $comment }}</p>
      </div>

    </div>
  </div>

  {{-- ── Stat cards ── --}}
  <div class="ar-stats">
    <div class="ar-stat blue">
      <div class="ar-stat-icon">🎯</div>
      <div class="ar-stat-val">{{ $score }} / {{ $total }}</div>
      <div class="ar-stat-lbl">Correct Answers</div>
    </div>
    <div class="ar-stat green">
      <div class="ar-stat-icon">📊</div>
      <div class="ar-stat-val">{{ $pct }}%</div>
      <div class="ar-stat-lbl">Accuracy</div>
    </div>
    <div class="ar-stat amber">
      <div class="ar-stat-icon">⏱️</div>
      <div class="ar-stat-val">{{ $mins }}m</div>
      <div class="ar-stat-lbl">Time Taken</div>
    </div>
    <div class="ar-stat purple">
      <div class="ar-stat-icon">⚡</div>
      <div class="ar-stat-val">L-{{ (int) $assessment->current_difficulty }}</div>
      <div class="ar-stat-lbl">Final Difficulty</div>
    </div>
  </div>

  {{-- ── Weak topics ── --}}
  <div class="ar-card">
    <div class="ar-card-head">
      <div>
        <h2>📉 Topics to Improve</h2>
        <p>Focus on these areas to boost your next score</p>
      </div>
      @if($weakTopics->isNotEmpty())
        <span class="ar-count-pill">{{ $weakTopics->count() }} weak {{ Str::plural('topic', $weakTopics->count()) }}</span>
      @else
        <span class="ar-count-pill ok">✓ All good</span>
      @endif
    </div>

    @if($weakTopics->isEmpty())
      <div class="ar-empty">
        <div class="ar-empty-icon">🎉</div>
        <p>No weak topics found — great balanced performance!</p>
      </div>
    @else
      <div class="ar-topic-list">
        @foreach($weakTopics as $topic)
          @php
            $acc = (int) $topic->accuracy;
            $accClass = $acc < 50 ? 'low' : 'mid';
            $fillClass = $acc < 50 ? 'fill-low' : 'fill-mid';
          @endphp
          <div class="ar-topic-row">
            <div class="ar-topic-icon">⚠️</div>
            <div class="ar-topic-info">
              <div class="ar-topic-name">{{ $topic->topic }}</div>
              <div class="ar-topic-sub">{{ $topic->total }} {{ Str::plural('question', $topic->total) }} attempted</div>
            </div>
            <div class="ar-topic-right">
              <div class="ar-topic-acc {{ $accClass }}">{{ $acc }}%</div>
              <div class="ar-topic-bar-wrap">
                <div class="ar-topic-bar-fill {{ $fillClass }}" style="width:{{ $acc }}%"></div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  {{-- ── CTA buttons ── --}}
  <div class="ar-cta">
    <a href="{{ route('assessments', [], false) }}" class="ar-btn-primary">
      📝 Back to Assessments
    </a>
    <a href="{{ route('learn', [], false) }}" class="ar-btn-outline">
      🎯 Continue Learning
    </a>
  </div>

</div>
@endsection