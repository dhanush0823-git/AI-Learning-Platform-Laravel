@extends('layouts.app')

@section('title', 'Adaptive Assessment')

@push('styles')
<style>
  .aa-wrap { max-width: 860px; margin: 28px auto; padding: 0 20px 48px; display: flex; flex-direction: column; gap: 14px; }

  /* ── Top bar ── */
  .aa-topbar {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    padding: 18px 24px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
    display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap;
  }
  .aa-topbar-left { display: flex; align-items: center; gap: 14px; }
  .aa-topbar-icon {
    width: 46px; height: 46px; border-radius: 14px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center; font-size: 22px;
    box-shadow: 0 4px 12px rgba(66,133,244,.28);
  }
  .aa-topbar h1 { font-size: 17px; font-weight: 800; color: #1a1a1a; margin: 0 0 3px; }
  .aa-topbar p  { font-size: 12.5px; color: #888; margin: 0; }
  .aa-badges { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

  .aa-badge {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 13px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
  }
  .aa-badge.diff { background: #eff6ff; border: 1px solid #bfdbfe; color: #4285F4; }
  .aa-badge.timer { background: #f3f4f6; border: 1px solid #e5e7eb; color: #374151; font-variant-numeric: tabular-nums; }

  /* ── Progress card ── */
  .aa-progress {
    background: #fff; border: 1px solid #eaeaea; border-radius: 16px;
    padding: 16px 20px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .aa-prog-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
  .aa-prog-label { font-size: 13px; font-weight: 600; color: #555; }
  .aa-prog-frac  { font-size: 13px; font-weight: 800; color: #4285F4; }
  .aa-prog-bar   { height: 9px; background: #f0f0f0; border-radius: 99px; overflow: hidden; }
  .aa-prog-fill  { height: 100%; border-radius: 99px; background: linear-gradient(90deg,#4285F4,#34A853); transition: width .5s ease; }
  .aa-prog-dots  { display: flex; gap: 5px; margin-top: 12px; flex-wrap: wrap; }
  .aa-dot {
    width: 24px; height: 24px; border-radius: 7px; flex-shrink: 0;
    background: #f3f4f6; border: 1.5px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-weight: 700; color: #bbb; transition: all .2s;
  }
  .aa-dot.answered { background: linear-gradient(135deg,#4285F4,#34A853); border-color: transparent; color: #fff; box-shadow: 0 2px 6px rgba(66,133,244,.28); }
  .aa-dot.current  { border-color: #4285F4; background: #eff6ff; color: #4285F4; }

  /* ── Question card ── */
  .aa-qcard {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04);
    transition: box-shadow .2s;
  }
  .aa-qcard-stripe { height: 3px; background: linear-gradient(90deg,#4285F4,#34A853); }
  .aa-qcard-head { padding: 20px 24px 16px; border-bottom: 1px solid #f3f4f6; }

  .aa-qmeta { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; flex-wrap: wrap; }
  .aa-qmeta-pill {
    font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px;
  }
  .pill-topic  { background: #eff6ff; border: 1px solid #bfdbfe; color: #4285F4; }
  .pill-diff-1 { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
  .pill-diff-2 { background: #fffbeb; border: 1px solid #fde68a; color: #d97706; }
  .pill-diff-3 { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

  .aa-qtext {
    font-size: 18px; font-weight: 800; color: #1a1a1a; line-height: 1.5;
    margin: 0; min-height: 52px;
    display: flex; align-items: flex-start; gap: 12px;
  }
  .aa-q-num {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 14px; font-weight: 800;
    box-shadow: 0 3px 8px rgba(66,133,244,.25); margin-top: 2px;
  }

  /* ── Options ── */
  .aa-options { padding: 20px 24px; display: flex; flex-direction: column; gap: 10px; }
  .aa-opt {
    display: flex; align-items: center; gap: 13px;
    padding: 14px 16px; border: 1.5px solid #eaeaea; border-radius: 14px;
    cursor: pointer; transition: all .15s; background: #fafafa; user-select: none;
  }
  .aa-opt:hover { border-color: #bfdbfe; background: #f8fbff; transform: translateX(4px); }
  .aa-opt input[type="radio"] { display: none; }
  .aa-opt:has(input:checked) { border-color: #4285F4; background: #eff6ff; }
  .aa-opt-key {
    width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0;
    background: #f0f0f0; border: 1.5px solid #e0e0e0;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; color: #888; transition: all .15s;
  }
  .aa-opt:has(input:checked) .aa-opt-key {
    background: linear-gradient(135deg,#4285F4,#34A853); border-color: transparent; color: #fff;
    box-shadow: 0 2px 6px rgba(66,133,244,.3);
  }
  .aa-opt-text { font-size: 14px; color: #1a1a1a; line-height: 1.5; flex: 1; }

  /* ── Action bar ── */
  .aa-actions {
    padding: 18px 24px; border-top: 1px solid #f3f4f6;
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
  }
  .aa-submit-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px; border: none; border-radius: 13px; cursor: pointer;
    background: linear-gradient(135deg,#4285F4,#34A853); color: #fff;
    font-size: 14px; font-weight: 700; font-family: inherit;
    box-shadow: 0 4px 12px rgba(66,133,244,.32); transition: all .15s;
  }
  .aa-submit-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 7px 18px rgba(66,133,244,.4); }
  .aa-submit-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; box-shadow: none; }

  .aa-finish-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 20px; border: 1.5px solid #e5e7eb; border-radius: 13px; cursor: pointer;
    background: #fff; color: #555; font-size: 14px; font-weight: 700; font-family: inherit;
    transition: all .15s;
  }
  .aa-finish-btn:hover { background: #fef2f2; border-color: #fecaca; color: #dc2626; }

  .aa-action-hint { font-size: 12px; color: #bbb; margin-left: auto; }

  /* ── Loading skeleton ── */
  .aa-skeleton { animation: shimmer 1.4s infinite linear; border-radius: 10px; background: linear-gradient(90deg,#f0f0f0 25%,#e8e8e8 50%,#f0f0f0 75%); background-size: 200% 100%; }
  @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
  .sk-title { height: 28px; width: 75%; margin-bottom: 12px; }
  .sk-opt   { height: 50px; border-radius: 14px; }

  @media (max-width: 600px) {
    .aa-wrap { padding: 0 12px 40px; margin-top: 20px; }
    .aa-topbar { padding: 14px 16px; }
    .aa-qcard-head,.aa-options,.aa-actions { padding-left: 16px; padding-right: 16px; }
    .aa-qtext { font-size: 16px; }
  }
</style>
@endpush

@section('content')
<div class="aa-wrap">

  {{-- ── Top bar ── --}}
  <div class="aa-topbar">
    <div class="aa-topbar-left">
      <div class="aa-topbar-icon">🧠</div>
      <div>
        <h1>Adaptive Assessment</h1>
        <p>Questions adapt to your skill level in real time</p>
      </div>
    </div>
    <div class="aa-badges">
      <span class="aa-badge diff" id="difficultyBadge">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        Level <span id="diffVal">{{ (int) $assessment->current_difficulty }}</span>
      </span>
      <span class="aa-badge timer" id="timerLabel">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span id="timerVal">00:00</span>
      </span>
    </div>
  </div>

  {{-- ── Progress ── --}}
  <div class="aa-progress">
    <div class="aa-prog-top">
      <span class="aa-prog-label">Assessment Progress</span>
      <span class="aa-prog-frac" id="progressText">0 / {{ (int) $assessment->total_questions }}</span>
    </div>
    <div class="aa-prog-bar">
      <div class="aa-prog-fill" id="progressBar" style="width:0%"></div>
    </div>
    <div class="aa-prog-dots" id="dotRow">
      @for($i = 1; $i <= (int) $assessment->total_questions; $i++)
        <div class="aa-dot" id="dot-{{ $i }}">{{ $i }}</div>
      @endfor
    </div>
  </div>

  {{-- ── Question card ── --}}
  <div class="aa-qcard" id="questionCard">
    <div class="aa-qcard-stripe"></div>
    <div class="aa-qcard-head">
      <div class="aa-qmeta" id="questionMeta">
        <div class="aa-skeleton sk-title" style="height:16px;width:140px;"></div>
      </div>
      <div class="aa-qtext" id="questionText">
        <div style="flex:1;">
          <div class="aa-skeleton sk-title"></div>
          <div class="aa-skeleton" style="height:20px;width:55%;margin-top:8px;"></div>
        </div>
      </div>
    </div>

    <form id="answerForm">
      @csrf
      <input type="hidden" id="question_id" name="question_id">
      <div class="aa-options" id="optionsBox">
        @for($i = 0; $i < 4; $i++)
          <div class="aa-skeleton sk-opt"></div>
        @endfor
      </div>
      <div class="aa-actions">
        <button type="submit" class="aa-submit-btn" id="submitBtn">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Submit Answer
        </button>
        <button type="button" class="aa-finish-btn" id="finishBtn">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"/>
          </svg>
          Finish Early
        </button>
        <span class="aa-action-hint" id="actionHint">Select an option to continue</span>
      </div>
    </form>
  </div>

</div>
@endsection

@push('scripts')
<script>
const nextUrl    = @json(route('assessments.adaptive.next',   $assessment, false));
const answerUrl  = @json(route('assessments.adaptive.answer', $assessment, false));
const finishUrl  = @json(route('assessments.adaptive.finish', $assessment, false));
const resultUrl  = @json(route('assessments.adaptive.result', $assessment, false));
const csrfToken  = @json(csrf_token());
const totalQ     = {{ (int) $assessment->total_questions }};

let questionStartAt = Date.now();
let overallSec = {{ (int) $assessment->time_taken }};
let answeredCount = 0;
const submitBtnDefault = `
  <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
  </svg>
  Submit Answer
`;

/* ── Timer ── */
const timerEl = document.getElementById('timerVal');
function fmtSec(s) {
  return String(Math.floor(s/60)).padStart(2,'0')+':'+String(s%60).padStart(2,'0');
}
timerEl.textContent = fmtSec(overallSec);
setInterval(() => { overallSec++; timerEl.textContent = fmtSec(overallSec); }, 1000);

/* ── Difficulty badge update ── */
function setDiff(d) {
  document.getElementById('diffVal').textContent = d;
  const badge = document.getElementById('difficultyBadge');
  badge.className = 'aa-badge ' + (d <= 1 ? 'diff-easy' : d <= 2 ? 'diff-med' : 'diff-hard') + ' diff';
}

/* ── Dot tracker ── */
function markDot(n, state) {
  const d = document.getElementById('dot-' + n);
  if (d) { d.className = 'aa-dot ' + state; }
}

/* ── Render question ── */
const KEYS = ['A','B','C','D','E'];
let currentQNum = 0;

function renderQuestion(question, answered) {
  questionStartAt = Date.now();
  answeredCount = answered;
  currentQNum = answered + 1;

  document.getElementById('question_id').value = question.id;

  /* meta pills */
  const diffLevel = question.difficulty_level || 1;
  const diffClass = diffLevel <= 1 ? 'pill-diff-1' : diffLevel <= 2 ? 'pill-diff-2' : 'pill-diff-3';
  const diffLabel = diffLevel <= 1 ? '🟢 Easy' : diffLevel <= 2 ? '🟡 Medium' : '🔴 Hard';
  document.getElementById('questionMeta').innerHTML = `
    <span class="aa-qmeta-pill pill-topic">${question.topic || 'General'}</span>
    <span class="aa-qmeta-pill ${diffClass}">${diffLabel}</span>
    <span class="aa-qmeta-pill pill-topic" style="background:#f5f6f8;border-color:#e8e9eb;color:#555;">Q ${currentQNum} of ${totalQ}</span>
  `;

  /* question text */
  document.getElementById('questionText').innerHTML = `
    <div class="aa-q-num">${currentQNum}</div>
    <span>${question.text}</span>
  `;

  /* options */
  const opts = question.options || [];
  document.getElementById('optionsBox').innerHTML = opts.map((opt, idx) => `
    <label class="aa-opt">
      <input type="radio" name="selected_option" value="${String(opt).replace(/"/g,'&quot;')}" required>
      <span class="aa-opt-key">${KEYS[idx] || idx+1}</span>
      <span class="aa-opt-text">${opt}</span>
    </label>
  `).join('');

  /* progress */
  const pct = totalQ > 0 ? Math.round((answered / totalQ) * 100) : 0;
  document.getElementById('progressBar').style.width = pct + '%';
  document.getElementById('progressText').textContent = answered + ' / ' + totalQ;

  /* dots */
  for (let i = 1; i <= totalQ; i++) {
    markDot(i, i <= answered ? 'answered' : i === currentQNum ? 'current' : '');
  }

  document.getElementById('actionHint').textContent = 'Select an option to continue';
  const submitBtn = document.getElementById('submitBtn');
  submitBtn.disabled = false;
  submitBtn.innerHTML = submitBtnDefault;
}

/* ── Load next question ── */
async function loadNext() {
  const res = await fetch(nextUrl, { headers: { Accept: 'application/json' } });
  const data = await res.json();
  if (data.done) { window.location.href = resultUrl; return; }
  renderQuestion(data.question, data.progress.answered);
}

/* ── Submit ── */
document.getElementById('answerForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const sel = document.querySelector('input[name="selected_option"]:checked');
  if (!sel) { document.getElementById('actionHint').textContent = '⚠️ Please select an option first!'; return; }

  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.innerHTML = `<svg style="width:16px;height:16px;animation:spin 1s linear infinite" fill="none" viewBox="0 0 24 24"><circle style="opacity:.25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"/><path style="opacity:.85;fill:white" d="M4 12a8 8 0 018-8v8H4z"/></svg> Submitting…`;

  const spent = Math.max(0, Math.round((Date.now() - questionStartAt) / 1000));
  const res = await fetch(answerUrl, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json' },
    body: JSON.stringify({ question_id: document.getElementById('question_id').value, selected_option: sel.value, time_spent_seconds: spent })
  });
  if (!res.ok) {
    btn.disabled = false;
    btn.innerHTML = submitBtnDefault;
    return;
  }

  const data = await res.json();
  document.getElementById('diffVal').textContent = data.current_difficulty;

  markDot(currentQNum, 'answered');

  if (data.done) { window.location.href = resultUrl; return; }
  loadNext();
});

/* ── Finish early ── */
document.getElementById('finishBtn').addEventListener('click', async () => {
  if (!confirm('Finish the assessment early? Your current answers will be saved.')) return;
  const res = await fetch(finishUrl, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json' }
  });
  const data = await res.json();
  window.location.href = data.redirect || resultUrl;
});

/* spin keyframe */
const s = document.createElement('style');
s.textContent = '@keyframes spin{to{transform:rotate(360deg)}}';
document.head.appendChild(s);

/* kick off */
loadNext();
</script>
@endpush
