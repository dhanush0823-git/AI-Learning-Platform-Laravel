@extends('layouts.app')

@section('title', 'Adaptive Assessment')

@section('content')
<section style="max-width: 920px; margin: 24px auto; padding: 0 16px;">
    <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:16px;">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
            <div>
                <h1 style="margin:0; font-size:22px;">Adaptive Assessment</h1>
                <p style="margin:6px 0 0; color:#6b7280; font-size:14px;">Questions adapt based on your answers.</p>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <span id="difficultyBadge" style="padding:6px 10px; border-radius:999px; font-size:12px; font-weight:700; background:#eff6ff; color:#1d4ed8;">Difficulty L-{{ (int) $assessment->current_difficulty }}</span>
                <span id="timerLabel" style="padding:6px 10px; border-radius:999px; font-size:12px; font-weight:700; background:#f3f4f6; color:#374151;">00:00</span>
            </div>
        </div>

        <div style="margin-top:14px;">
            <div style="height:8px; background:#f3f4f6; border-radius:999px; overflow:hidden;">
                <div id="progressBar" style="height:100%; width:0%; background:linear-gradient(90deg,#4285F4,#34A853);"></div>
            </div>
            <p id="progressText" style="margin:8px 0 0; color:#6b7280; font-size:13px;">Answered 0 / {{ (int) $assessment->total_questions }}</p>
        </div>

        <div id="questionCard" style="margin-top:16px; border:1px solid #e5e7eb; border-radius:10px; padding:14px;">
            <p id="questionMeta" style="margin:0 0 6px; color:#6b7280; font-size:12px;"></p>
            <h2 id="questionText" style="margin:0; font-size:20px;">Loading question...</h2>
            <form id="answerForm" style="margin-top:14px;">
                @csrf
                <input type="hidden" id="question_id" name="question_id">
                <div id="optionsBox" style="display:grid; gap:8px;"></div>
                <div style="display:flex; gap:10px; margin-top:14px;">
                    <button type="submit" style="padding:10px 14px; background:#2563eb; color:#fff; border:0; border-radius:8px; font-weight:600;">Submit Answer</button>
                    <button type="button" id="finishBtn" style="padding:10px 14px; background:#111827; color:#fff; border:0; border-radius:8px; font-weight:600;">Finish</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
const nextUrl = "{{ route('assessments.adaptive.next', $assessment, false) }}";
const answerUrl = "{{ route('assessments.adaptive.answer', $assessment, false) }}";
const finishUrl = "{{ route('assessments.adaptive.finish', $assessment, false) }}";
const resultUrl = "{{ route('assessments.adaptive.result', $assessment, false) }}";
const csrfToken = "{{ csrf_token() }}";
const totalQuestions = {{ (int) $assessment->total_questions }};
let questionStartAt = Date.now();
let overallSeconds = {{ (int) $assessment->time_taken }};

function renderTimer() {
  const mins = String(Math.floor(overallSeconds / 60)).padStart(2, '0');
  const secs = String(overallSeconds % 60).padStart(2, '0');
  document.getElementById('timerLabel').textContent = `${mins}:${secs}`;
}

setInterval(() => {
  overallSeconds += 1;
  renderTimer();
}, 1000);

function renderQuestion(question, answered) {
  questionStartAt = Date.now();
  document.getElementById('question_id').value = question.id;
  document.getElementById('questionMeta').textContent = `${question.topic || 'General'} • Difficulty ${question.difficulty_level}`;
  document.getElementById('questionText').textContent = question.text;

  const optionsBox = document.getElementById('optionsBox');
  optionsBox.innerHTML = (question.options || []).map((opt, idx) => {
    const id = `opt_${idx}`;
    return `
      <label for="${id}" style="display:flex; align-items:center; gap:8px; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; cursor:pointer;">
        <input id="${id}" type="radio" name="selected_option" value="${String(opt).replace(/"/g, '&quot;')}" required>
        <span>${opt}</span>
      </label>
    `;
  }).join('');

  const pct = totalQuestions > 0 ? Math.round((answered / totalQuestions) * 100) : 0;
  document.getElementById('progressBar').style.width = `${pct}%`;
  document.getElementById('progressText').textContent = `Answered ${answered} / ${totalQuestions}`;
}

async function loadNextQuestion() {
  const res = await fetch(nextUrl, { headers: { 'Accept': 'application/json' } });
  const data = await res.json();
  if (data.done) {
    window.location.href = resultUrl;
    return;
  }
  renderQuestion(data.question, data.progress.answered);
}

document.getElementById('answerForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const selected = document.querySelector('input[name="selected_option"]:checked');
  if (!selected) return;

  const spent = Math.max(0, Math.round((Date.now() - questionStartAt) / 1000));
  const payload = {
    question_id: document.getElementById('question_id').value,
    selected_option: selected.value,
    time_spent_seconds: spent
  };

  const res = await fetch(answerUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    },
    body: JSON.stringify(payload)
  });

  if (!res.ok) return;
  const data = await res.json();
  document.getElementById('difficultyBadge').textContent = `Difficulty L-${data.current_difficulty}`;
  if (data.done) {
    window.location.href = resultUrl;
    return;
  }
  loadNextQuestion();
});

document.getElementById('finishBtn').addEventListener('click', async () => {
  const res = await fetch(finishUrl, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    }
  });
  const data = await res.json();
  window.location.href = data.redirect || resultUrl;
});

renderTimer();
loadNextQuestion();
</script>
@endsection

