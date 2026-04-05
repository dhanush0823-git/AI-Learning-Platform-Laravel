@extends('layouts.app')

@section('title', 'Assessments - AI Learning Platform')

@push('styles')
<style>
  .as-wrap { max-width: 860px; margin: 32px auto; padding: 0 20px 48px; display: flex; flex-direction: column; gap: 16px; }

  /* ── Header ── */
  .as-header {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    padding: 22px 26px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
    display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
  }
  .as-header-left { display: flex; align-items: center; gap: 14px; }
  .as-icon {
    width: 52px; height: 52px; border-radius: 16px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center; font-size: 26px;
    box-shadow: 0 4px 14px rgba(66,133,244,.3);
  }
  .as-header h1 { font-size: 20px; font-weight: 800; color: #1a1a1a; margin: 0 0 4px; }
  .as-header p  { font-size: 13px; color: #888; margin: 0; }
  .as-features { display: flex; gap: 8px; flex-wrap: wrap; }
  .as-feat-pill {
    display: flex; align-items: center; gap: 6px;
    background: #f5f6f8; border: 1px solid #e8e9eb;
    border-radius: 20px; padding: 6px 13px;
    font-size: 12px; font-weight: 600; color: #555;
  }

  /* ── Status banner ── */
  .as-status {
    display: flex; align-items: flex-start; gap: 12px;
    background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 14px;
    padding: 14px 18px; color: #065f46;
  }
  .as-status-icon { font-size: 20px; flex-shrink: 0; }
  .as-status-text { font-size: 13.5px; font-weight: 600; }

  /* ── Info cards row ── */
  .as-info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
  .as-info-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 16px;
    padding: 18px; box-shadow: 0 2px 6px rgba(0,0,0,.04); text-align: center;
    transition: box-shadow .2s, transform .2s;
  }
  .as-info-card:hover { box-shadow: 0 8px 22px rgba(0,0,0,.08); transform: translateY(-2px); }
  .as-info-emoji { font-size: 28px; margin-bottom: 8px; }
  .as-info-title { font-size: 13px; font-weight: 800; color: #1a1a1a; margin-bottom: 3px; }
  .as-info-sub   { font-size: 12px; color: #aaa; line-height: 1.5; }

  /* ── Form card ── */
  .as-form-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .as-form-head {
    padding: 18px 24px; border-bottom: 1px solid #f3f4f6;
    display: flex; align-items: center; gap: 10px;
  }
  .as-form-head-icon {
    width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center; font-size: 16px;
  }
  .as-form-head h2 { font-size: 15px; font-weight: 800; color: #1a1a1a; margin: 0; }
  .as-form-head p  { font-size: 12px; color: #aaa; margin: 2px 0 0; }
  .as-form-body { padding: 24px; display: flex; flex-direction: column; gap: 20px; }

  /* ── Field ── */
  .as-field { display: flex; flex-direction: column; gap: 8px; }
  .as-field label { font-size: 13.5px; font-weight: 700; color: #374151; display: flex; align-items: center; gap: 7px; }
  .as-field-sub { font-size: 12px; color: #aaa; margin: -4px 0 0; }
  .as-select {
    width: 100%; padding: 12px 14px; border: 1.5px solid #e8e9eb;
    border-radius: 13px; font-size: 14px; font-family: inherit; color: #1a1a1a;
    background: #f9fafb; outline: none; cursor: pointer;
    transition: border .15s, box-shadow .15s; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke='%23aaa' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center;
    padding-right: 42px;
  }
  .as-select:focus { border-color: #4285F4; box-shadow: 0 0 0 3px rgba(66,133,244,.12); background-color: #fff; }

  /* ── Question count picker ── */
  .as-count-group { display: flex; gap: 10px; }
  .as-count-opt { flex: 1; }
  .as-count-opt input[type="radio"] { display: none; }
  .as-count-opt label {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 4px; padding: 14px 10px; border: 1.5px solid #e8e9eb; border-radius: 14px;
    cursor: pointer; transition: all .15s; background: #f9fafb;
    font-weight: 700; color: #888; font-size: 13px;
  }
  .as-count-opt label .cnt-num { font-size: 22px; font-weight: 800; color: #555; }
  .as-count-opt label .cnt-lbl { font-size: 11px; color: #aaa; }
  .as-count-opt input:checked + label {
    border-color: #4285F4; background: #eff6ff; color: #4285F4;
  }
  .as-count-opt input:checked + label .cnt-num { color: #4285F4; }
  .as-count-opt input:checked + label .cnt-lbl { color: #93c5fd; }
  .as-count-opt label:hover { border-color: #bfdbfe; background: #f0f8ff; }

  /* ── Divider ── */
  .as-divider { display: flex; align-items: center; gap: 12px; }
  .as-divider-line { flex: 1; height: 1px; background: #f0f0f0; }
  .as-divider-text { font-size: 11.5px; color: #ccc; font-weight: 600; white-space: nowrap; }

  /* ── Submit ── */
  .as-submit-row { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
  .as-submit-btn {
    display: inline-flex; align-items: center; gap: 9px;
    padding: 13px 28px; border: none; border-radius: 14px; cursor: pointer;
    background: linear-gradient(135deg,#4285F4,#34A853); color: #fff;
    font-size: 14px; font-weight: 700; font-family: inherit;
    box-shadow: 0 4px 14px rgba(66,133,244,.35); transition: all .15s;
  }
  .as-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 7px 20px rgba(66,133,244,.4); }
  .as-submit-btn:disabled { opacity: .55; cursor: not-allowed; transform: none; box-shadow: none; }
  .as-submit-hint { font-size: 12px; color: #bbb; }

  @media (max-width: 640px) {
    .as-wrap { padding: 0 12px 40px; margin-top: 20px; }
    .as-info-grid { grid-template-columns: 1fr; }
    .as-count-group { flex-direction: column; }
    .as-header { padding: 16px 18px; }
    .as-form-body { padding: 18px; }
  }
</style>
@endpush

@section('content')
<div class="as-wrap">

  {{-- ── Header ── --}}
  <div class="as-header">
    <div class="as-header-left">
      <div class="as-icon">📝</div>
      <div>
        <h1>Assessments</h1>
        <p>Adaptive quizzes that personalize your learning journey</p>
      </div>
    </div>
    <div class="as-features">
      <div class="as-feat-pill">🤖 AI-Adaptive</div>
      <div class="as-feat-pill">⚡ Instant Results</div>
      <div class="as-feat-pill">🎯 Personalized</div>
    </div>
  </div>

  {{-- ── Status banner ── --}}
  @if(session('status'))
    <div class="as-status">
      <span class="as-status-icon">✅</span>
      <span class="as-status-text">{{ session('status') }}</span>
    </div>
  @endif

  {{-- ── Info cards ── --}}
  <div class="as-info-grid">
    <div class="as-info-card">
      <div class="as-info-emoji">🧠</div>
      <div class="as-info-title">Adaptive AI</div>
      <div class="as-info-sub">Questions adjust to your skill level in real time</div>
    </div>
    <div class="as-info-card">
      <div class="as-info-emoji">📊</div>
      <div class="as-info-title">Instant Feedback</div>
      <div class="as-info-sub">Get detailed results and explanations right away</div>
    </div>
    <div class="as-info-card">
      <div class="as-info-emoji">🚀</div>
      <div class="as-info-title">Track Growth</div>
      <div class="as-info-sub">Each attempt improves your personalized learning path</div>
    </div>
  </div>

  {{-- ── Form ── --}}
  <div class="as-form-card">
    <div class="as-form-head">
      <div class="as-form-head-icon">⚙️</div>
      <div>
        <h2>Configure Your Assessment</h2>
        <p>Choose a course focus and question count to begin</p>
      </div>
    </div>

    <form method="POST" action="{{ route('assessments.adaptive.start', [], false) }}" id="assessForm">
      @csrf
      <div class="as-form-body">

        {{-- Course select --}}
        <div class="as-field">
          <label for="course_id">
            <span>📚</span> Course Focus
          </label>
          <p class="as-field-sub">Leave on department-wide to pull questions from all your courses</p>
          <select id="course_id" name="course_id" class="as-select">
            <option value="">🏛️ Department-wide assessment</option>
            @foreach($courses as $course)
              <option value="{{ $course->id }}">📘 {{ $course->title }}</option>
            @endforeach
          </select>
        </div>

        <div class="as-divider">
          <div class="as-divider-line"></div>
          <span class="as-divider-text">Number of Questions</span>
          <div class="as-divider-line"></div>
        </div>

        {{-- Question count picker --}}
        <div class="as-field">
          <label>⏱️ How many questions?</label>
          <div class="as-count-group">
            <div class="as-count-opt">
              <input type="radio" id="q10" name="question_count" value="10" checked>
              <label for="q10">
                <span class="cnt-num">10</span>
                <span class="cnt-lbl">~10 mins</span>
              </label>
            </div>
            <div class="as-count-opt">
              <input type="radio" id="q15" name="question_count" value="15">
              <label for="q15">
                <span class="cnt-num">15</span>
                <span class="cnt-lbl">~15 mins</span>
              </label>
            </div>
            <div class="as-count-opt">
              <input type="radio" id="q20" name="question_count" value="20">
              <label for="q20">
                <span class="cnt-num">20</span>
                <span class="cnt-lbl">~20 mins</span>
              </label>
            </div>
          </div>
        </div>

        <div class="as-submit-row">
          <button type="submit" class="as-submit-btn" id="startBtn">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Start Adaptive Assessment
          </button>
          <span class="as-submit-hint">Your results will update your learning path automatically</span>
        </div>

      </div>
    </form>
  </div>

</div>
@endsection

@push('scripts')
<script>
  document.getElementById('assessForm')?.addEventListener('submit', function() {
    const btn = document.getElementById('startBtn');
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = `<svg style="width:18px;height:18px;animation:spin 1s linear infinite" fill="none" viewBox="0 0 24 24">
        <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"/>
        <path style="opacity:.85;fill:white" d="M4 12a8 8 0 018-8v8H4z"/>
      </svg> Starting...`;
    }
  });
  const s = document.createElement('style');
  s.textContent = '@keyframes spin{to{transform:rotate(360deg)}}';
  document.head.appendChild(s);
</script>
@endpush