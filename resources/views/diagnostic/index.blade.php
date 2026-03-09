@extends('layouts.app')

@section('title', 'Diagnostic Test - AI Learning Platform')

@push('styles')
<style>
  .dt-wrap { max-width: 860px; margin: 32px auto; padding: 0 20px 48px; display: flex; flex-direction: column; gap: 16px; }

  /* ── Header card ── */
  .dt-header {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    padding: 22px 26px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
    display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
  }
  .dt-header-left { display: flex; align-items: center; gap: 14px; }
  .dt-icon {
    width: 50px; height: 50px; border-radius: 16px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center; font-size: 26px;
    box-shadow: 0 4px 14px rgba(66,133,244,.3);
  }
  .dt-header h1 { font-size: 20px; font-weight: 800; color: #1a1a1a; margin: 0 0 4px; }
  .dt-header p  { font-size: 13px; color: #888; margin: 0; }
  .dt-meta {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
  }
  .dt-pill {
    display: flex; align-items: center; gap: 6px;
    background: #f5f6f8; border: 1px solid #e8e9eb; border-radius: 20px;
    padding: 6px 13px; font-size: 12px; font-weight: 600; color: #555;
  }

  /* ── Alert banners ── */
  .dt-alert {
    border-radius: 14px; padding: 14px 18px;
    display: flex; align-items: flex-start; gap: 12px;
    border: 1px solid;
  }
  .dt-alert-icon { font-size: 20px; flex-shrink: 0; margin-top: 1px; }
  .dt-alert-body { flex: 1; }
  .dt-alert-title { font-size: 13px; font-weight: 700; margin: 0 0 2px; }
  .dt-alert-sub   { font-size: 13px; margin: 0; }
  .dt-alert.warn  { background: #fff7ed; border-color: #fdba74; color: #9a3412; }
  .dt-alert.info  { background: #ecfeff; border-color: #67e8f9; color: #0f766e; }
  .dt-alert-link  {
    display: inline-flex; align-items: center; gap: 4px;
    margin-top: 7px; font-size: 12.5px; font-weight: 700;
    color: #0e7490; text-decoration: none; background: #fff;
    border: 1px solid #a5f3fc; border-radius: 8px; padding: 4px 10px;
    transition: background .15s;
  }
  .dt-alert-link:hover { background: #cffafe; }

  /* ── Progress bar ── */
  .dt-progress-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 16px;
    padding: 16px 20px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .dt-prog-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
  .dt-prog-label  { font-size: 13px; font-weight: 600; color: #555; }
  .dt-prog-count  { font-size: 13px; font-weight: 700; color: #4285F4; }
  .dt-prog-bar    { height: 8px; background: #f0f0f0; border-radius: 99px; overflow: hidden; }
  .dt-prog-fill   { height: 100%; border-radius: 99px; background: linear-gradient(90deg,#4285F4,#34A853); transition: width .4s ease; }

  /* ── Empty state ── */
  .dt-empty {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    padding: 60px 24px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .dt-empty-icon { font-size: 48px; margin-bottom: 14px; }
  .dt-empty h3   { font-size: 16px; font-weight: 800; color: #333; margin: 0 0 6px; }
  .dt-empty p    { font-size: 13px; color: #aaa; margin: 0; }

  /* ── Question card ── */
  .q-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
    transition: box-shadow .2s;
  }
  .q-card:focus-within { box-shadow: 0 0 0 3px rgba(66,133,244,.12), 0 4px 16px rgba(0,0,0,.06); }

  .q-header { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px; }
  .q-num {
    width: 36px; height: 36px; border-radius: 11px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 13px; font-weight: 800;
    box-shadow: 0 3px 8px rgba(66,133,244,.28);
  }
  .q-text { font-size: 15px; font-weight: 700; color: #1a1a1a; line-height: 1.55; margin: 0; padding-top: 4px; }

  /* ── Option labels ── */
  .q-options { display: grid; gap: 10px; }
  .q-option {
    display: flex; align-items: center; gap: 12px;
    padding: 13px 16px; border-radius: 14px;
    border: 1.5px solid #eaeaea; cursor: pointer;
    transition: border-color .15s, background .15s, transform .1s;
    position: relative; user-select: none;
  }
  .q-option:hover { border-color: #bfdbfe; background: #f8fbff; transform: translateX(3px); }
  .q-option input[type="radio"] { display: none; }
  .q-option input[type="radio"]:checked ~ .q-opt-marker {
    background: linear-gradient(135deg,#4285F4,#34A853);
    border-color: transparent; color: #fff;
  }
  .q-option:has(input:checked) {
    border-color: #4285F4; background: #eff6ff;
  }
  .q-opt-marker {
    width: 28px; height: 28px; border-radius: 9px; flex-shrink: 0;
    background: #f3f4f6; border: 1.5px solid #ddd;
    display: flex; align-items: center; justify-content: center;
    font-size: 11.5px; font-weight: 800; color: #888; transition: all .15s;
  }
  .q-opt-text { font-size: 14px; color: #374151; line-height: 1.5; flex: 1; }

  /* ── Submit area ── */
  .dt-submit-area {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;
    gap: 16px; flex-wrap: wrap; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .dt-submit-info { font-size: 13px; color: #888; }
  .dt-submit-info strong { color: #1a1a1a; }
  .dt-submit-btn {
    display: inline-flex; align-items: center; gap: 9px;
    padding: 12px 28px; border: none; border-radius: 14px; cursor: pointer;
    background: linear-gradient(135deg,#4285F4,#34A853); color: #fff;
    font-size: 14px; font-weight: 700; font-family: inherit;
    box-shadow: 0 4px 14px rgba(66,133,244,.35); transition: all .15s;
  }
  .dt-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 7px 20px rgba(66,133,244,.4); }
  .dt-submit-btn:disabled { opacity: .55; cursor: not-allowed; transform: none; box-shadow: none; }

  /* ── Answered tracker ── */
  .dt-tracker { display: flex; flex-wrap: wrap; gap: 6px; }
  .tracker-dot {
    width: 28px; height: 28px; border-radius: 8px;
    background: #f3f4f6; border: 1.5px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; color: #aaa; transition: all .2s;
  }
  .tracker-dot.answered {
    background: linear-gradient(135deg,#4285F4,#34A853);
    border-color: transparent; color: #fff;
    box-shadow: 0 2px 6px rgba(66,133,244,.28);
  }

  @media (max-width: 600px) {
    .dt-wrap { padding: 0 12px 40px; margin-top: 20px; }
    .dt-header { padding: 16px 18px; }
    .q-card { padding: 18px 16px; }
    .dt-submit-area { flex-direction: column; align-items: stretch; }
    .dt-submit-btn { width: 100%; justify-content: center; }
  }
</style>
@endpush

@section('content')
<div class="dt-wrap">

  {{-- ── Header ── --}}
  <div class="dt-header">
    <div class="dt-header-left">
      <div class="dt-icon">🧪</div>
      <div>
        <h1>Diagnostic Test</h1>
        <p>Department-based assessment to calibrate your learning level</p>
      </div>
    </div>
    <div class="dt-meta">
      @unless($questions->isEmpty())
        <div class="dt-pill">📝 {{ $questions->count() }} Questions</div>
        <div class="dt-pill">⏱️ ~{{ $questions->count() * 2 }} mins</div>
      @endunless
      <div class="dt-pill" style="color:#34A853;border-color:#bbf7d0;background:#f0fdf4;">🎯 Single Attempt</div>
    </div>
  </div>

  {{-- ── Warning banner ── --}}
  @if(session('warning'))
    <div class="dt-alert warn">
      <span class="dt-alert-icon">⚠️</span>
      <div class="dt-alert-body">
        <p class="dt-alert-title">Heads up</p>
        <p class="dt-alert-sub">{{ session('warning') }}</p>
      </div>
    </div>
  @endif

  {{-- ── Previous result banner ── --}}
  @if($latestAttempt)
    <div class="dt-alert info">
      <span class="dt-alert-icon">📊</span>
      <div class="dt-alert-body">
        <p class="dt-alert-title">Previous Result</p>
        <p class="dt-alert-sub">
          Score: <strong>{{ $latestAttempt->score }}/{{ $latestAttempt->total_questions }}</strong>
          &nbsp;·&nbsp;
          <strong>{{ number_format($latestAttempt->percentage, 1) }}%</strong>
          &nbsp;·&nbsp;
          Level assigned: <strong>{{ ucfirst($latestAttempt->assigned_level) }}</strong>
        </p>
        <a href="{{ route('diagnostic.result', ['attemptId' => $latestAttempt->id], false) }}" class="dt-alert-link">
          View Full Result →
        </a>
      </div>
    </div>
  @endif

  {{-- ── Empty state ── --}}
  @if($questions->isEmpty())
    <div class="dt-empty">
      <div class="dt-empty-icon">🔬</div>
      <h3>No Questions Available</h3>
      <p>Diagnostic questions for your department haven't been set up yet.<br>Please check back later.</p>
    </div>

  @else
    {{-- ── Progress tracker ── --}}
    <div class="dt-progress-card">
      <div class="dt-prog-header">
        <span class="dt-prog-label">Your Progress</span>
        <span class="dt-prog-count" id="answeredCount">0 / {{ $questions->count() }} answered</span>
      </div>
      <div class="dt-prog-bar">
        <div class="dt-prog-fill" id="progressFill" style="width:0%"></div>
      </div>
      <div class="dt-tracker" style="margin-top:12px;" id="dotTracker">
        @foreach($questions as $i => $question)
          <div class="tracker-dot" id="dot-{{ $question->id }}" title="Q{{ $i+1 }}">{{ $i+1 }}</div>
        @endforeach
      </div>
    </div>

    {{-- ── Questions form ── --}}
    <form method="POST" action="{{ route('diagnostic.submit', [], false) }}" id="dtForm" style="display:contents;">
      @csrf

      @foreach($questions as $index => $question)
        <div class="q-card" id="qcard-{{ $question->id }}">
          <div class="q-header">
            <div class="q-num">{{ $index + 1 }}</div>
            <p class="q-text">{{ $question->question }}</p>
          </div>
          <div class="q-options">
            @foreach(['a','b','c','d'] as $opt)
              @php $field = "option_{$opt}"; @endphp
              <label class="q-option">
                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $opt }}"
                  data-qid="{{ $question->id }}" data-total="{{ $questions->count() }}" required>
                <span class="q-opt-marker">{{ strtoupper($opt) }}</span>
                <span class="q-opt-text">{{ $question->{$field} }}</span>
              </label>
            @endforeach
          </div>
        </div>
      @endforeach

      {{-- ── Submit area ── --}}
      <div class="dt-submit-area">
        <div class="dt-submit-info">
          Answer all <strong>{{ $questions->count() }} questions</strong> to submit.<br>
          <span style="color:#aaa;font-size:12px;">Once submitted, your level will be assigned automatically.</span>
        </div>
        <button type="submit" class="dt-submit-btn" id="submitBtn">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Submit Diagnostic Test
        </button>
      </div>

    </form>
  @endif

</div>
@endsection

@push('scripts')
<script>
  const total = {{ $questions->count() }};
  let answered = {};

  document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
      const qid = this.dataset.qid;
      answered[qid] = true;

      // Update dot
      const dot = document.getElementById('dot-' + qid);
      if (dot) dot.classList.add('answered');

      // Update progress bar
      const count = Object.keys(answered).length;
      const pct   = total > 0 ? Math.round((count / total) * 100) : 0;
      const fill  = document.getElementById('progressFill');
      const label = document.getElementById('answeredCount');
      if (fill)  fill.style.width  = pct + '%';
      if (label) label.textContent = count + ' / ' + total + ' answered';
    });
  });

  // Submit guard
  document.getElementById('dtForm')?.addEventListener('submit', function(e) {
    const count = Object.keys(answered).length;
    if (count < total) {
      e.preventDefault();
      alert('Please answer all ' + total + ' questions before submitting.');
      // Scroll to first unanswered
      document.querySelectorAll('input[type="radio"]').forEach(r => {
        if (!answered[r.dataset.qid]) {
          r.closest('.q-card')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
          return;
        }
      });
      return;
    }
    const btn = document.getElementById('submitBtn');
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = `<svg style="width:18px;height:18px;animation:spin 1s linear infinite" fill="none" viewBox="0 0 24 24">
        <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"/>
        <path style="opacity:.85;fill:white" d="M4 12a8 8 0 018-8v8H4z"/>
      </svg> Submitting...`;
    }
  });

  const s = document.createElement('style');
  s.textContent = '@keyframes spin{to{transform:rotate(360deg)}}';
  document.head.appendChild(s);
</script>
@endpush