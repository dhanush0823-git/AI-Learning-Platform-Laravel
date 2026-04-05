{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AI Learning Platform')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @endif

    <style>
      *, *::before, *::after { box-sizing: border-box; }
      body { font-family: 'Inter', system-ui, sans-serif; margin: 0; background: #f8f9fa; min-height: 100vh; display: flex; flex-direction: column; }

      /* ─── NAVBAR ─────────────────────────────── */
      .navbar {
        position: sticky; top: 0; z-index: 50;
        background: #fff;
        border-bottom: 1px solid #eaeaea;
        transition: box-shadow 0.25s;
      }
      .navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }

      .nav-inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 24px;
        height: 68px;              /* taller navbar */
        display: flex;
        align-items: center;
        gap: 14px;
      }

      /* ── Brand */
      .nav-brand {
        display: flex; align-items: center; gap: 11px;
        text-decoration: none; flex-shrink: 0;
      }
      .brand-icon {
        width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
        background: linear-gradient(135deg,#4285F4,#34A853);
        display: flex; align-items: center; justify-content: center; font-size: 20px;
      }
      .brand-text { line-height: 1; }
      .brand-name { font-size: 15px; font-weight: 800; color: #1a1a1a; white-space: nowrap; }
      .brand-sub  { font-size: 11.5px; color: #aaa; margin-top: 3px; white-space: nowrap; }

      /* ── Links pill */
      .nav-links {
        display: flex; align-items: center; gap: 3px;
        flex-wrap: nowrap;
        background: #f5f6f8; border: 1px solid #e8e9eb;
        border-radius: 14px; padding: 5px;
        flex: 1;
        min-width: 0;
        height: 52px;              /* taller pill */
        overflow: visible;
      }

      .nav-link {
        display: flex; align-items: center; gap: 6px;
        padding: 7px 14px;         /* more horizontal padding */
        border-radius: 10px;
        font-size: 14px; font-weight: 600;  /* bigger font */
        white-space: nowrap;
        text-decoration: none; color: #555;
        transition: background 0.15s, color 0.15s;
        flex-shrink: 0;
        height: 40px;              /* taller link items */
        line-height: 1;
      }
      .nav-link:hover:not(.active) { background: #fff; color: #111; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
      .nav-link.active {
        background: linear-gradient(135deg,#4285F4,#34A853);
        color: #fff !important;
        box-shadow: 0 3px 10px rgba(66,133,244,0.28);
      }

      .nav-icon { font-size: 16px; line-height: 1; }
      .nav-badge {
        font-size: 10px; font-weight: 800;
        padding: 3px 5px; border-radius: 5px; line-height: 1.2;
      }
      .badge-dt { background: #ede9fe; color: #7c3aed; }
      .badge-ai { background: #dbeafe; color: #1d4ed8; }

      /* ── Right side */
      .nav-right {
        display: flex; align-items: center; gap: 9px; flex-shrink: 0;
      }

      .user-pill {
        display: flex; align-items: center; gap: 9px;
        background: #f5f6f8; border: 1px solid #e8e9eb;
        border-radius: 14px; padding: 6px 12px 6px 7px;
      }
      .avatar {
        position: relative; width: 34px; height: 34px; border-radius: 50%;
        background: linear-gradient(135deg,#4285F4,#34A853);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 13px; font-weight: 800; flex-shrink: 0;
      }
      .avatar-dot {
        position: absolute; bottom: 0; right: 0;
        width: 8px; height: 8px; border-radius: 50%;
        background: #34A853; border: 2px solid #fff;
      }
      .uname { font-size: 13.5px; font-weight: 700; color: #1a1a1a; white-space: nowrap; }
      .urole { font-size: 11px; color: #aaa; }

      .logout-btn {
        font-size: 12.5px; font-weight: 600; color: #ef4444;
        background: #fef2f2; border: 1px solid #fecaca;
        border-radius: 8px; padding: 6px 12px; cursor: pointer;
        transition: background 0.15s; white-space: nowrap; font-family: inherit;
      }
      .logout-btn:hover { background: #fee2e2; }

      .btn-login {
        font-size: 13.5px; font-weight: 600; color: #4285F4;
        border: 1.5px solid #c7d8fd; background: #fff;
        border-radius: 10px; padding: 8px 16px;
        text-decoration: none; transition: all 0.15s; white-space: nowrap;
      }
      .btn-login:hover { background: #eff6ff; border-color: #4285F4; }

      .btn-signup {
        font-size: 13.5px; font-weight: 600; color: #fff;
        background: linear-gradient(135deg,#4285F4,#34A853);
        border-radius: 10px; padding: 8px 16px;
        text-decoration: none; white-space: nowrap;
        box-shadow: 0 3px 10px rgba(66,133,244,0.28);
        transition: all 0.15s;
      }
      .btn-signup:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(66,133,244,0.38); }

      .hamburger {
        display: none; width: 38px; height: 38px; border-radius: 10px;
        background: #f3f4f6; border: none; cursor: pointer;
        align-items: center; justify-content: center; flex-shrink: 0;
      }

      /* ── Responsive ──────────────────────────── */
      /* At 1180px the 7-item nav still fits comfortably */
      @media (max-width: 1080px) {
        .nav-links  { display: none; }
        .hamburger  { display: flex; }
        .brand-sub  { display: none; }
      }
      @media (max-width: 600px) {
        .uname, .urole { display: none; }
        .nav-inner { padding: 0 10px; }
        .btn-login { display: none; }
      }

      /* ── Mobile menu ─────────────────────────── */
      .mobile-menu { display: none; border-top: 1px solid #eaeaea; background: #fff; }
      .mobile-menu.open { display: block; }
      .mobile-menu-inner { max-width: 1400px; margin: 0 auto; padding: 8px 14px 14px; }
      .mob-link {
        display: flex; align-items: center; gap: 9px;
        padding: 9px 13px; border-radius: 10px; margin-bottom: 2px;
        font-size: 13.5px; font-weight: 600; color: #555;
        text-decoration: none; transition: background 0.15s;
      }
      .mob-link:hover { background: #f5f6f8; color: #111; }
      .mob-link.active { background: linear-gradient(135deg,#4285F4,#34A853); color: #fff; }
      .mob-auth { display: flex; gap: 8px; margin-top: 10px; padding-top: 10px; border-top: 1px solid #f0f0f0; }
      .mob-auth a {
        flex: 1; text-align: center; padding: 9px 12px;
        border-radius: 10px; font-size: 13px; font-weight: 600;
        text-decoration: none;
      }

      /* ─── FOOTER ─────────────────────────────── */
      .footer { background: linear-gradient(135deg,#1a1a1a,#2d2d2d); color: #fff; margin-top: auto; }
      .footer-inner { max-width: 1200px; margin: 0 auto; padding: 52px 24px 28px; }
      .footer-grid {
        display: grid;
        grid-template-columns: 1.3fr 1fr 1fr 0.8fr;
        gap: 36px;
        padding-bottom: 36px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
      }
      .f-logo { display: flex; align-items: center; gap: 9px; margin-bottom: 12px; }
      .f-logo-icon { width: 36px; height: 36px; border-radius: 9px; background: linear-gradient(135deg,#4285F4,#34A853); display: flex; align-items: center; justify-content: center; font-size: 17px; }
      .f-logo-name { font-size: 13.5px; font-weight: 800; }
      .f-logo-sub  { font-size: 10.5px; color: rgba(255,255,255,0.4); margin-top: 2px; }
      .f-desc { font-size: 12.5px; color: rgba(255,255,255,0.5); line-height: 1.65; margin-bottom: 14px; }
      .f-status { display: flex; gap: 12px; flex-wrap: wrap; }
      .f-status span { display: flex; align-items: center; gap: 5px; font-size: 11px; color: rgba(255,255,255,0.38); }
      .f-dot { width: 5px; height: 5px; border-radius: 50%; }
      .f-col h4 { font-size: 9.5px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,0.32); margin-bottom: 14px; }
      .f-col a, .f-col span { display: block; font-size: 12.5px; color: rgba(255,255,255,0.58); text-decoration: none; margin-bottom: 9px; transition: color 0.15s, padding-left 0.15s; }
      .f-col a:hover { color: #fff; padding-left: 4px; }
      .f-bottom { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; padding-top: 22px; }
      .f-bottom p, .f-bottom span { font-size: 11.5px; color: rgba(255,255,255,0.32); }
      .f-bottom-right { display: flex; gap: 16px; }
      @media (max-width: 900px)  { .footer-grid { grid-template-columns: 1fr 1fr; } }
      @media (max-width: 520px)  { .footer-grid { grid-template-columns: 1fr; } .f-bottom { flex-direction: column; text-align: center; } }

      /* Pagination (global) */
      nav[aria-label="Pagination Navigation"],
      .pagination-links nav {
        display: flex;
        align-items: center;
        justify-content: flex-end;
      }
      .pagination-links span,
      .pagination-links nav span,
      nav[aria-label="Pagination Navigation"] span {
        display: flex;
        align-items: center;
        gap: 4px;
      }
      nav[aria-label="Pagination Navigation"] button,
      nav[aria-label="Pagination Navigation"] a,
      nav[aria-label="Pagination Navigation"] span > span,
      .pagination-links a,
      .pagination-links button,
      .pagination-links span > span {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 34px !important;
        height: 34px !important;
        padding: 0 10px !important;
        border-radius: 10px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        border: 1px solid #e8e9eb !important;
        background: #fff !important;
        color: #555 !important;
        text-decoration: none !important;
        transition: all 0.15s ease !important;
        cursor: pointer !important;
        line-height: 1 !important;
      }
      nav[aria-label="Pagination Navigation"] button:hover,
      nav[aria-label="Pagination Navigation"] a:hover,
      .pagination-links a:hover,
      .pagination-links button:hover {
        background: #eff6ff !important;
        border-color: #bfdbfe !important;
        color: #4285f4 !important;
      }
      nav[aria-label="Pagination Navigation"] button[aria-current="page"],
      nav[aria-label="Pagination Navigation"] span[aria-current="page"] span,
      .pagination-links span[aria-current="page"] span {
        background: linear-gradient(135deg, #4285f4, #34a853) !important;
        border-color: transparent !important;
        color: #fff !important;
        box-shadow: 0 3px 10px rgba(66, 133, 244, 0.3) !important;
      }
      nav[aria-label="Pagination Navigation"] span > span:not([aria-current]),
      .pagination-links span > span:not([aria-current]) {
        background: #f9fafb !important;
        color: #9ca3af !important;
        cursor: default !important;
        border-color: #f0f0f0 !important;
      }
      nav[aria-label="Pagination Navigation"] button:first-child,
      nav[aria-label="Pagination Navigation"] button:last-child,
      .pagination-links button:first-child,
      .pagination-links button:last-child,
      nav[aria-label="Pagination Navigation"] a[rel="prev"],
      nav[aria-label="Pagination Navigation"] a[rel="next"],
      .pagination-links a[rel="prev"],
      .pagination-links a[rel="next"] {
        background: #f5f6f8 !important;
        border-color: #e8e9eb !important;
        color: #4285f4 !important;
        font-weight: 700 !important;
      }
      nav[aria-label="Pagination Navigation"] a[rel="prev"]:hover,
      nav[aria-label="Pagination Navigation"] a[rel="next"]:hover,
      .pagination-links a[rel="prev"]:hover,
      .pagination-links a[rel="next"]:hover {
        background: #eff6ff !important;
        border-color: #4285f4 !important;
      }
      nav[aria-label="Pagination Navigation"] button:disabled,
      .pagination-links button:disabled {
        opacity: 0.4 !important;
        cursor: not-allowed !important;
        pointer-events: none !important;
      }
      nav[aria-label="Pagination Navigation"] > p.text-sm { display: none !important; }
      nav[aria-label="Pagination Navigation"] p.text-sm { display: none !important; }
      nav[aria-label="Pagination Navigation"] .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between > div:first-child { display: none !important; }
    </style>

    @stack('styles')
</head>
<body>
  @php
    $studentUser = auth('student')->user();
    $adminUser = auth('web')->user();
    $currentUser = $studentUser ?? $adminUser;
    $isStudentAuthenticated = ! is_null($studentUser);
    $isAdminAuthenticated = ! is_null($adminUser);
    $isAuthenticated = $isStudentAuthenticated || $isAdminAuthenticated;
    $dashboardRoute = $isAdminAuthenticated ? route('department.dashboard') : route('dashboard');
  @endphp

  {{-- ══ NAVBAR ══════════════════════════════════════ --}}
  <nav class="navbar" id="navbar">
    <div class="nav-inner">

      {{-- Brand --}}
      <a href="{{ route('home') }}" class="nav-brand">
        <div class="brand-icon">🎓</div>
        <div class="brand-text">
          <div class="brand-name">AI Learning Platform</div>
          <div class="brand-sub">Smart Education System</div>
        </div>
      </a>

      {{-- Desktop links --}}
      <div class="nav-links">
        <a href="{{ route('home') }}"        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"><span class="nav-icon">🏠</span>Home</a>
        <a href="{{ route('courses') }}"     class="nav-link {{ request()->routeIs('courses*') ? 'active' : '' }}"><span class="nav-icon">📚</span>Courses</a>
        <a href="{{ route('learn') }}"       class="nav-link {{ request()->routeIs('learn*') ? 'active' : '' }}"><span class="nav-icon">🎯</span>Learning Path</a>
        @if($isStudentAuthenticated)
        <a href="{{ route('diagnostic.test') }}" class="nav-link {{ request()->routeIs('diagnostic.*') ? 'active' : '' }}"><span class="nav-badge badge-dt">DT</span>Diagnostic</a>
        <a href="{{ route('chat.index') }}"  class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}"><span class="nav-badge badge-ai">AI</span>AI Chat</a>
        @endif
        <a href="{{ route('assessments') }}" class="nav-link {{ request()->routeIs('assessments*') ? 'active' : '' }}"><span class="nav-icon">📝</span>Assessments</a>
        <a href="{{ $dashboardRoute }}"   class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('department.dashboard') ? 'active' : '' }}"><span class="nav-icon">📊</span>Dashboard</a>
      </div>

      {{-- Right --}}
      <div class="nav-right">
        @if($isAuthenticated)
          <div class="user-pill">
            <div class="avatar">
              {{ strtoupper(substr($currentUser->name ?? 'U', 0, 1)) }}
              <div class="avatar-dot"></div>
            </div>
            <div style="display:flex;flex-direction:column;">
              <span class="uname">{{ $currentUser->name }}</span>
              <span class="urole">{{ $isAdminAuthenticated ? 'Department Admin' : 'Learner' }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;margin:0;">
              @csrf
              <button type="submit" class="logout-btn">Logout</button>
            </form>
          </div>
        @else
          <a href="{{ route('login') }}"    class="btn-login">🔑 Log In</a>
          <a href="{{ route('register') }}" class="btn-signup">✨ Sign Up</a>
        @endif
        <button class="hamburger" id="hamburger" onclick="toggleMobile()" aria-label="Menu">
          <svg id="ham-icon" width="17" height="17" fill="none" stroke="#555" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>

    {{-- Mobile menu --}}
    <div class="mobile-menu" id="mobileMenu">
      <div class="mobile-menu-inner">
        <a href="{{ route('home') }}"        class="mob-link {{ request()->routeIs('home') ? 'active' : '' }}">🏠 Home</a>
        <a href="{{ route('courses') }}"     class="mob-link {{ request()->routeIs('courses*') ? 'active' : '' }}">📚 Courses</a>
        <a href="{{ route('learn') }}"       class="mob-link {{ request()->routeIs('learn*') ? 'active' : '' }}">🎯 Learning Path</a>
        @if($isStudentAuthenticated)
        <a href="{{ route('diagnostic.test') }}" class="mob-link {{ request()->routeIs('diagnostic.*') ? 'active' : '' }}">🧪 Diagnostic Test</a>
        <a href="{{ route('chat.index') }}"  class="mob-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">🤖 AI Chat</a>
        @endif
        <a href="{{ route('assessments') }}" class="mob-link {{ request()->routeIs('assessments*') ? 'active' : '' }}">📝 Assessments</a>
        <a href="{{ $dashboardRoute }}"   class="mob-link {{ request()->routeIs('dashboard') || request()->routeIs('department.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        @unless($isAuthenticated)
        <div class="mob-auth">
          <a href="{{ route('login') }}"    style="color:#4285F4;border:1.5px solid #c7d8fd;">🔑 Log In</a>
          <a href="{{ route('register') }}" style="color:#fff;background:linear-gradient(135deg,#4285F4,#34A853);">✨ Sign Up</a>
        </div>
        @endunless
      </div>
    </div>
  </nav>

  {{-- ══ MAIN ════════════════════════════════════════ --}}
  <main style="flex:1;">
    @yield('content')
  </main>

  {{-- ══ FOOTER ══════════════════════════════════════ --}}
  <footer class="footer">
    <div class="footer-inner">
      <div class="footer-grid">
        <div>
          <div class="f-logo">
            <div class="f-logo-icon">🎓</div>
            <div>
              <div class="f-logo-name">AI Learning Platform</div>
              <div class="f-logo-sub">Smart Education System</div>
            </div>
          </div>
          <p class="f-desc">AI-powered personalized learning for engineering colleges with department-specific courses and real-time progress tracking.</p>
          <div class="f-status">
            <span><span class="f-dot" style="background:#34A853;"></span>System Online</span>
            <span><span class="f-dot" style="background:#4285F4;"></span>AI Active 🤖</span>
          </div>
        </div>
        <div class="f-col">
          <h4>Platform</h4>
          <a href="{{ route('courses') }}">Courses</a>
          <a href="{{ route('dashboard') }}">Dashboard</a>
          <a href="{{ route('assessments') }}">Assessments</a>
          <a href="{{ route('learn') }}">Learning Path</a>
        </div>
        <div class="f-col">
          <h4>Support</h4>
          <a href="{{ route('help') }}">Help Center</a>
          <a href="{{ route('contact') }}">Contact Us</a>
          <a href="{{ route('privacy') }}">Privacy Policy</a>
          <a href="{{ route('terms') }}">Terms of Service</a>
        </div>
        <div class="f-col">
          <h4>Departments</h4>
          <span>💻 CSE</span>
          <span>⚡ ECE</span>
          <span>⚙️ MECH</span>
          <span>🤖 AIML</span>
          <span>🏗️ CIVIL</span>
        </div>
      </div>
      <div class="f-bottom">
        <p>© {{ date('Y') }} AI Learning Platform. Smart Education System for Engineering Colleges.</p>
        <div class="f-bottom-right">
          <span>System: Operational ✓</span>
          <span>AI Assistant: Online 🤖</span>
        </div>
      </div>
    </div>
  </footer>

  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
      @vite(['resources/js/app.js'])
  @endif
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    window.addEventListener('scroll', () => {
      document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 8);
    });
    function toggleMobile() {
      const m = document.getElementById('mobileMenu');
      const i = document.getElementById('ham-icon');
      const open = m.classList.toggle('open');
      i.innerHTML = open
        ? '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>'
        : '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>';
    }
  </script>
  @stack('scripts')
</body>
</html>



