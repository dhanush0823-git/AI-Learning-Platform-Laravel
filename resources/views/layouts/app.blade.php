{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AI Learning Platform')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}" type="image/x-icon">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
          }
        }
      }
    </script>

    <!-- Vite (only if built) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @endif

    <style>
      body { font-family: 'Inter', system-ui, sans-serif; }

      /* Active nav item gradient */
      .nav-active {
        background: linear-gradient(135deg, #4285F4 0%, #34A853 100%);
        color: white !important;
        box-shadow: 0 4px 12px rgba(66,133,244,0.3);
      }

      /* Gradient text */
      .gradient-text {
        background: linear-gradient(135deg, #4285F4, #34A853);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      }

      /* Gradient button */
      .btn-gradient {
        background: linear-gradient(135deg, #4285F4 0%, #34A853 100%);
        transition: all 0.2s ease;
      }
      .btn-gradient:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(66,133,244,0.35);
      }

      /* Footer gradient bg */
      .footer-bg {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
      }

      /* Scrolled navbar shadow */
      .nav-scrolled {
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      }

      /* Mobile menu transition */
      #mobileMenu { transition: max-height 0.3s ease, opacity 0.3s ease; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

  {{-- ════════════════════════════════════
       NAVBAR
  ════════════════════════════════════ --}}
  <nav id="navbar"
       class="bg-white border-b border-gray-200 sticky top-0 z-50 transition-all duration-300"
       style="font-family: Inter, system-ui, sans-serif;">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
      <div class="flex items-center justify-between h-16 gap-4">

        {{-- Brand --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0 group">
          <div class="w-9 h-9 rounded-xl btn-gradient flex items-center justify-center text-lg flex-shrink-0">
            🎓
          </div>
          <div class="hidden sm:block">
            <span class="text-base font-extrabold text-gray-900 leading-none block">AI Learning Platform</span>
            <span class="text-xs text-gray-400 leading-none mt-0.5 block">Smart Education System</span>
          </div>
        </a>

        {{-- Desktop Nav Links --}}
        <div class="hidden lg:flex items-center gap-1 bg-gray-50 border border-gray-200 rounded-xl px-2 py-1.5">

          <a href="{{ route('home') }}"
             class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all
                    {{ request()->routeIs('home') ? 'nav-active' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
            <span class="text-base leading-none">🏠</span>
            <span>Home</span>
          </a>

          <a href="{{ route('courses') }}"
             class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all
                    {{ request()->routeIs('courses*') ? 'nav-active' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
            <span class="text-base leading-none">📚</span>
            <span>Courses</span>
          </a>

          <a href="{{ route('learn') }}"
             class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all
                    {{ request()->routeIs('learn*') ? 'nav-active' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
            <span class="text-base leading-none">🎯</span>
            <span>Learning Path</span>
          </a>

          @auth('student')
          <a href="{{ route('diagnostic.test') }}"
             class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all
                    {{ request()->routeIs('diagnostic.*') ? 'nav-active' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
            <span class="text-xs font-bold leading-none bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded">DT</span>
            <span>Diagnostic</span>
          </a>

          <a href="{{ route('chat.index') }}"
             class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all
                    {{ request()->routeIs('chat.*') ? 'nav-active' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
            <span class="text-xs font-bold leading-none bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded">AI</span>
            <span>AI Chat</span>
          </a>
          @endauth

          <a href="{{ route('assessments') }}"
             class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all
                    {{ request()->routeIs('assessments*') ? 'nav-active' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
            <span class="text-base leading-none">📝</span>
            <span>Assessments</span>
          </a>

          <a href="{{ route('dashboard') }}"
             class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all
                    {{ request()->routeIs('dashboard') ? 'nav-active' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
            <span class="text-base leading-none">📊</span>
            <span>Dashboard</span>
          </a>

        </div>

        {{-- Right: User / Auth --}}
        <div class="flex items-center gap-2 flex-shrink-0">

          @auth('student')
            {{-- User profile pill --}}
            <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2">
              <div class="relative flex-shrink-0">
                <div class="w-7 h-7 rounded-full btn-gradient flex items-center justify-center text-white text-xs font-bold">
                  {{ strtoupper(substr(auth('student')->user()->name, 0, 1)) }}
                </div>
                <div class="absolute bottom-0 right-0 w-2 h-2 bg-green-500 rounded-full border border-white"></div>
              </div>
              <div class="hidden md:block">
                <p class="text-xs font-bold text-gray-800 leading-none">{{ auth('student')->user()->name }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Learner</p>
              </div>
              <form method="POST" action="{{ route('logout') }}" class="ml-1">
                @csrf
                <button type="submit"
                  class="text-xs font-semibold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded-lg transition-colors border border-red-100">
                  Logout
                </button>
              </form>
            </div>
          @else
            <a href="{{ route('login') }}"
               class="hidden sm:flex items-center gap-1.5 text-sm font-semibold text-blue-600 border border-blue-200 hover:border-blue-400 bg-white hover:bg-blue-50 px-3.5 py-2 rounded-xl transition-all">
              🔑 Log In
            </a>
            <a href="{{ route('register') }}"
               class="flex items-center gap-1.5 text-sm font-semibold text-white btn-gradient px-3.5 py-2 rounded-xl shadow-sm">
              ✨ Sign Up
            </a>
          @endauth

          {{-- Mobile hamburger --}}
          <button id="mobileToggle"
            class="lg:hidden w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors"
            onclick="toggleMobile()">
            <svg id="menuIcon" class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>

        </div>
      </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="lg:hidden hidden border-t border-gray-100 bg-white">
      <div class="max-w-screen-xl mx-auto px-4 py-3 space-y-1">

        <a href="{{ route('home') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                  {{ request()->routeIs('home') ? 'nav-active' : 'text-gray-600 hover:bg-gray-50' }}">
          🏠 Home
        </a>
        <a href="{{ route('courses') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                  {{ request()->routeIs('courses*') ? 'nav-active' : 'text-gray-600 hover:bg-gray-50' }}">
          📚 Courses
        </a>
        <a href="{{ route('learn') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                  {{ request()->routeIs('learn*') ? 'nav-active' : 'text-gray-600 hover:bg-gray-50' }}">
          🎯 Learning Path
        </a>

        @auth('student')
        <a href="{{ route('diagnostic.test') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                  {{ request()->routeIs('diagnostic.*') ? 'nav-active' : 'text-gray-600 hover:bg-gray-50' }}">
          🧪 Diagnostic Test
        </a>
        <a href="{{ route('chat.index') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                  {{ request()->routeIs('chat.*') ? 'nav-active' : 'text-gray-600 hover:bg-gray-50' }}">
          🤖 AI Chat
        </a>
        @endauth

        <a href="{{ route('assessments') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                  {{ request()->routeIs('assessments*') ? 'nav-active' : 'text-gray-600 hover:bg-gray-50' }}">
          📝 Assessments
        </a>
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                  {{ request()->routeIs('dashboard') ? 'nav-active' : 'text-gray-600 hover:bg-gray-50' }}">
          📊 Dashboard
        </a>

        @guest('student')
        <div class="flex gap-2 pt-2 border-t border-gray-100 mt-2">
          <a href="{{ route('login') }}"
             class="flex-1 text-center text-sm font-semibold text-blue-600 border border-blue-200 px-4 py-2.5 rounded-xl hover:bg-blue-50 transition-colors">
            🔑 Log In
          </a>
          <a href="{{ route('register') }}"
             class="flex-1 text-center text-sm font-semibold text-white btn-gradient px-4 py-2.5 rounded-xl">
            ✨ Sign Up
          </a>
        </div>
        @endguest

      </div>
    </div>
  </nav>

  {{-- ════════════════════════════════════
       MAIN CONTENT
  ════════════════════════════════════ --}}
  <main class="flex-1">
    @yield('content')
  </main>

  {{-- ════════════════════════════════════
       FOOTER
  ════════════════════════════════════ --}}
  <footer class="footer-bg text-white mt-auto">
    <div class="max-w-screen-xl mx-auto px-6 py-14">

      {{-- Top grid --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-10 pb-10 border-b border-white/10">

        {{-- Brand column --}}
        <div class="md:col-span-1">
          <div class="flex items-center gap-2.5 mb-4">
            <div class="w-10 h-10 rounded-xl btn-gradient flex items-center justify-center text-xl">🎓</div>
            <div>
              <span class="text-base font-extrabold text-white block leading-none">AI Learning Platform</span>
              <span class="text-xs text-white/50 mt-0.5 block">Smart Education System</span>
            </div>
          </div>
          <p class="text-sm text-white/60 leading-relaxed max-w-xs">
            Smart education system for engineering colleges with AI-powered personalized learning paths and real-time progress tracking.
          </p>
          {{-- Status badges --}}
          <div class="flex items-center gap-3 mt-5">
            <div class="flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-green-400"></span>
              <span class="text-xs text-white/50">System Online</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-blue-400"></span>
              <span class="text-xs text-white/50">AI Active 🤖</span>
            </div>
          </div>
        </div>

        {{-- Links columns --}}
        <div class="md:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-8">

          <div>
            <h4 class="text-xs font-bold text-white/40 uppercase tracking-widest mb-4">Platform</h4>
            <div class="space-y-2.5">
              <a href="{{ route('courses') }}"     class="block text-sm text-white/70 hover:text-white transition-colors hover:translate-x-1 transform">Courses</a>
              <a href="{{ route('dashboard') }}"   class="block text-sm text-white/70 hover:text-white transition-colors hover:translate-x-1 transform">Dashboard</a>
              <a href="{{ route('assessments') }}" class="block text-sm text-white/70 hover:text-white transition-colors hover:translate-x-1 transform">Assessments</a>
              <a href="{{ route('learn') }}"       class="block text-sm text-white/70 hover:text-white transition-colors hover:translate-x-1 transform">Learning Path</a>
            </div>
          </div>

          <div>
            <h4 class="text-xs font-bold text-white/40 uppercase tracking-widest mb-4">Support</h4>
            <div class="space-y-2.5">
              <a href="{{ route('help') }}"    class="block text-sm text-white/70 hover:text-white transition-colors hover:translate-x-1 transform">Help Center</a>
              <a href="{{ route('contact') }}" class="block text-sm text-white/70 hover:text-white transition-colors hover:translate-x-1 transform">Contact Us</a>
              <a href="{{ route('privacy') }}" class="block text-sm text-white/70 hover:text-white transition-colors hover:translate-x-1 transform">Privacy Policy</a>
              <a href="{{ route('terms') }}"   class="block text-sm text-white/70 hover:text-white transition-colors hover:translate-x-1 transform">Terms of Service</a>
            </div>
          </div>

          <div>
            <h4 class="text-xs font-bold text-white/40 uppercase tracking-widest mb-4">Departments</h4>
            <div class="space-y-2.5">
              <span class="block text-sm text-white/70">💻 CSE</span>
              <span class="block text-sm text-white/70">⚡ ECE</span>
              <span class="block text-sm text-white/70">⚙️ MECH</span>
              <span class="block text-sm text-white/70">🤖 AIML</span>
              <span class="block text-sm text-white/70">🏗️ CIVIL</span>
            </div>
          </div>

        </div>
      </div>

      {{-- Bottom bar --}}
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6">
        <p class="text-xs text-white/40 text-center sm:text-left">
          © {{ date('Y') }} AI Learning Platform. Smart Education System for Engineering Colleges.
        </p>
        <div class="flex items-center gap-4">
          <span class="flex items-center gap-1.5 text-xs text-white/40">
            <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
            System Operational
          </span>
          <span class="text-xs text-white/40">AI Assistant: Online 🤖</span>
        </div>
      </div>

    </div>
  </footer>

  {{-- Scripts --}}
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
      @vite(['resources/js/app.js'])
  @endif
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <script>
    // Mobile menu toggle
    function toggleMobile() {
      const menu = document.getElementById('mobileMenu');
      const icon = document.getElementById('menuIcon');
      const isOpen = !menu.classList.contains('hidden');
      menu.classList.toggle('hidden');
      icon.innerHTML = isOpen
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
    }

    // Navbar scroll shadow
    window.addEventListener('scroll', () => {
      const nav = document.getElementById('navbar');
      if (window.scrollY > 10) {
        nav.classList.add('nav-scrolled');
      } else {
        nav.classList.remove('nav-scrolled');
      }
    });
  </script>

  @stack('scripts')
</body>
</html>