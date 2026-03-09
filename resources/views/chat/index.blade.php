@extends('layouts.app')

@section('title', 'AI Chat - AI Learning Platform')

@push('styles')
<style>
  /* ── Layout ─────────────────────────────── */
  .chat-wrap {
    max-width: 860px; margin: 32px auto; padding: 0 20px 40px;
    display: flex; flex-direction: column; gap: 16px;
  }

  /* ── Header card ─────────────────────────── */
  .chat-header {
    background: #fff; border: 1px solid #eaeaea;
    border-radius: 20px; padding: 20px 24px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; flex-wrap: wrap;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .chat-header-left { display: flex; align-items: center; gap: 14px; }
  .ai-avatar {
    width: 50px; height: 50px; border-radius: 16px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    display: flex; align-items: center; justify-content: center; font-size: 26px;
    box-shadow: 0 4px 14px rgba(66,133,244,.3);
  }
  .chat-header h1 { font-size: 18px; font-weight: 800; color: #1a1a1a; margin: 0 0 3px; }
  .chat-header p  { font-size: 13px; color: #888; margin: 0; }
  .ai-online {
    display: flex; align-items: center; gap: 7px;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 20px; padding: 7px 14px;
    font-size: 12px; font-weight: 700; color: #16a34a;
  }
  .ai-online-dot {
    width: 7px; height: 7px; border-radius: 50%; background: #22c55e;
    animation: blink 1.8s ease-in-out infinite;
  }
  @keyframes blink { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }

  /* ── Messages area ──────────────────────── */
  .chat-messages {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    padding: 20px; min-height: 380px; max-height: 500px;
    overflow-y: auto; display: flex; flex-direction: column; gap: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    scroll-behavior: smooth;
  }
  .chat-messages::-webkit-scrollbar { width: 5px; }
  .chat-messages::-webkit-scrollbar-track { background: transparent; }
  .chat-messages::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }

  /* ── Empty state ──────────────────────── */
  .chat-empty {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    text-align: center; padding: 32px 20px; color: #aaa;
  }
  .empty-blob {
    width: 72px; height: 72px; border-radius: 20px;
    background: linear-gradient(135deg,#eff6ff,#f0fdf4);
    border: 1px solid #e0e7ff;
    display: flex; align-items: center; justify-content: center;
    font-size: 34px; margin: 0 auto 16px;
  }
  .chat-empty h3 { font-size: 16px; font-weight: 800; color: #333; margin: 0 0 6px; }
  .chat-empty p  { font-size: 13px; margin: 0 0 20px; color: #aaa; }
  .suggestions   { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
  .suggestion-chip {
    background: #fff; border: 1.5px solid #e0e7ff;
    color: #4285F4; border-radius: 20px; padding: 7px 14px;
    font-size: 12.5px; font-weight: 600; cursor: pointer;
    transition: all .15s; box-shadow: 0 1px 4px rgba(66,133,244,.08);
  }
  .suggestion-chip:hover {
    background: #eff6ff; border-color: #4285F4;
    transform: translateY(-1px); box-shadow: 0 4px 10px rgba(66,133,244,.15);
  }

  /* ── Message bubbles ────────────────────── */
  .msg-row { display: flex; gap: 10px; animation: fadeUp .22s ease both; }
  .msg-row.user { flex-direction: row-reverse; }
  @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:none} }

  .bubble-avatar {
    width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 800; color: #fff;
    align-self: flex-end; box-shadow: 0 2px 6px rgba(0,0,0,.12);
  }
  .bubble-avatar.user { background: linear-gradient(135deg,#4285F4,#6ea8fe); }
  .bubble-avatar.ai   { background: linear-gradient(135deg,#34A853,#6ee7a0); font-size: 18px; }

  .bubble-body { max-width: 76%; display: flex; flex-direction: column; gap: 4px; }
  .bubble-label { font-size: 10.5px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: #bbb; }
  .msg-row.user .bubble-label { text-align: right; }

  .bubble {
    padding: 12px 15px; border-radius: 18px;
    font-size: 14px; line-height: 1.65; white-space: pre-wrap; word-break: break-word;
  }
  .bubble.user {
    background: linear-gradient(135deg,#4285F4,#5a9ef8);
    color: #fff; border-bottom-right-radius: 5px;
    box-shadow: 0 4px 14px rgba(66,133,244,.28);
  }
  .bubble.ai {
    background: #f5f6f8; color: #1a1a1a;
    border-bottom-left-radius: 5px;
    border: 1px solid #eaeaea;
  }
  .bubble-time { font-size: 10px; color: #d0d0d0; }
  .msg-row.user .bubble-time { text-align: right; }

  /* ── Input area ─────────────────────────── */
  .chat-input-card {
    background: #fff; border: 1px solid #eaeaea; border-radius: 20px;
    padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .chat-input-row { display: flex; align-items: flex-end; gap: 10px; }
  .chat-textarea {
    flex: 1; border: 1.5px solid #e8e9eb; border-radius: 14px;
    padding: 12px 15px; font-size: 14px; font-family: inherit; color: #1a1a1a;
    background: #f9fafb; resize: none; min-height: 48px; max-height: 150px;
    overflow-y: auto; outline: none; line-height: 1.55;
    transition: border .15s, box-shadow .15s;
  }
  .chat-textarea:focus {
    border-color: #4285F4;
    box-shadow: 0 0 0 3px rgba(66,133,244,.12);
    background: #fff;
  }
  .chat-textarea::placeholder { color: #c0c4cc; }

  .chat-send-btn {
    width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0;
    background: linear-gradient(135deg,#4285F4,#34A853);
    border: none; cursor: pointer; color: #fff;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 12px rgba(66,133,244,.35);
    transition: all .15s;
  }
  .chat-send-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 7px 18px rgba(66,133,244,.4); }
  .chat-send-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; box-shadow: none; }
  .chat-send-btn svg { width: 20px; height: 20px; }

  .chat-input-footer {
    display: flex; align-items: center; justify-content: space-between;
    margin-top: 10px; padding-top: 10px; border-top: 1px solid #f3f4f6;
  }
  .chat-hint { font-size: 11.5px; color: #ccc; display: flex; align-items: center; gap: 4px; }
  .chat-hint kbd {
    background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px;
    padding: 1px 6px; font-size: 10.5px; color: #888; font-family: inherit;
  }
  .char-count { font-size: 11.5px; color: #bbb; font-variant-numeric: tabular-nums; }

  /* ── Typing dots ─────────────────────────── */
  .typing-row { display: none; }
  .typing-row.show { display: flex; }
  .typing-dots {
    padding: 13px 16px; background: #f5f6f8; border: 1px solid #eaeaea;
    border-radius: 18px; border-bottom-left-radius: 5px;
    display: flex; gap: 5px; align-items: center;
  }
  .typing-dots span {
    width: 7px; height: 7px; background: #c0c0c0; border-radius: 50%;
    animation: dotBounce .9s ease-in-out infinite;
  }
  .typing-dots span:nth-child(2) { animation-delay: .18s; }
  .typing-dots span:nth-child(3) { animation-delay: .36s; }
  @keyframes dotBounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-7px);background:#4285F4} }

  @media (max-width: 600px) {
    .chat-wrap { padding: 0 12px 32px; margin-top: 20px; }
    .chat-messages { max-height: 360px; min-height: 280px; }
    .bubble { font-size: 13px; }
  }
</style>
@endpush

@section('content')
<div class="chat-wrap">

  {{-- ── Header ── --}}
  <div class="chat-header">
    <div class="chat-header-left">
      <div class="ai-avatar">🤖</div>
      <div>
        <h1>AI Doubt Solver</h1>
        <p>Ask any question — get instant, accurate answers</p>
      </div>
    </div>
    <div class="ai-online">
      <span class="ai-online-dot"></span>
      AI Online
    </div>
  </div>

  {{-- ── Messages ── --}}
  <div class="chat-messages" id="chatMessages">

    @forelse($messages as $msg)
      @php $isUser = ($msg['role'] === 'user'); @endphp
      <div class="msg-row {{ $isUser ? 'user' : 'ai' }}">
        <div class="bubble-avatar {{ $isUser ? 'user' : 'ai' }}">
          {{ $isUser ? strtoupper(substr(auth('student')->user()->name ?? 'U', 0, 1)) : '🤖' }}
        </div>
        <div class="bubble-body">
          <span class="bubble-label">{{ $isUser ? 'You' : 'AI Solver' }}</span>
          <div class="bubble {{ $isUser ? 'user' : 'ai' }}">{{ $msg['content'] }}</div>
          <span class="bubble-time">Just now</span>
        </div>
      </div>
    @empty
      <div class="chat-empty">
        <div class="empty-blob">💬</div>
        <h3>Start a conversation</h3>
        <p>Ask anything about your courses, concepts, or assignments.</p>
        <div class="suggestions">
          <span class="suggestion-chip" onclick="fillInput(this)">Explain recursion in Python</span>
          <span class="suggestion-chip" onclick="fillInput(this)">What is Ohm's Law?</span>
          <span class="suggestion-chip" onclick="fillInput(this)">How does binary search work?</span>
          <span class="suggestion-chip" onclick="fillInput(this)">Summarize Newton's laws</span>
        </div>
      </div>
    @endforelse

    {{-- Typing indicator --}}
    <div class="msg-row ai typing-row" id="typingRow">
      <div class="bubble-avatar ai">🤖</div>
      <div class="bubble-body">
        <span class="bubble-label">AI Solver</span>
        <div class="typing-dots">
          <span></span><span></span><span></span>
        </div>
      </div>
    </div>

  </div>

  {{-- ── Input ── --}}
  <div class="chat-input-card">
    <form id="chatForm" method="POST" action="{{ route('chat.ask', [], false) }}">
      @csrf
      <div class="chat-input-row">
        <textarea
          id="chatInput"
          name="message"
          placeholder="Ask your doubt here..."
          rows="1"
          required
          maxlength="1000"
          class="chat-textarea"
          oninput="autoResize(this); updateCount(this)"
          onkeydown="handleKey(event)"
        ></textarea>
        <button id="chatSubmitBtn" type="submit" class="chat-send-btn" title="Send message">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
          </svg>
        </button>
      </div>
      <div class="chat-input-footer">
        <span class="chat-hint">
          <kbd>Enter</kbd> send &nbsp;·&nbsp; <kbd>Shift+Enter</kbd> new line
        </span>
        <span class="char-count" id="charCount">0 / 1000</span>
      </div>
    </form>
  </div>

</div>
@endsection

@push('scripts')
<script>
  // Scroll to bottom on load
  const chatBox = document.getElementById('chatMessages');
  if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

  function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 150) + 'px';
  }

  function updateCount(el) {
    const c = document.getElementById('charCount');
    if (c) c.textContent = el.value.length + ' / 1000';
  }

  function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      document.getElementById('chatForm')?.requestSubmit();
    }
  }

  function fillInput(chip) {
    const input = document.getElementById('chatInput');
    if (!input) return;
    input.value = chip.textContent;
    input.focus();
    autoResize(input);
    updateCount(input);
  }

  document.getElementById('chatForm')?.addEventListener('submit', function(e) {
    const input  = document.getElementById('chatInput');
    const btn    = document.getElementById('chatSubmitBtn');
    const typing = document.getElementById('typingRow');

    if (!input || !input.value.trim()) { e.preventDefault(); return; }

    if (typing) {
      typing.classList.add('show');
      if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
    }
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = `<svg style="width:20px;height:20px;animation:spin 1s linear infinite" fill="none" viewBox="0 0 24 24">
        <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"/>
        <path style="opacity:.85;fill:white" d="M4 12a8 8 0 018-8v8H4z"/>
      </svg>`;
    }
  });
  // CSS spin for the loading icon
  const s = document.createElement('style');
  s.textContent = '@keyframes spin{to{transform:rotate(360deg)}}';
  document.head.appendChild(s);
</script>
@endpush