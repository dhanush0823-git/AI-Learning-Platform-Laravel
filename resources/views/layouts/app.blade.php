{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AI Learning Platform')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    
    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @endif
    @stack('styles')
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar @if(request()->routeIs('home')) navbar-transparent @endif" 
         x-data="{ scrolled: false }" 
         @scroll.window="scrolled = window.scrollY > 10">
        <div class="nav-container" :class="{ 'navbar-scrolled': scrolled }">
            <div class="nav-brand">
                <a href="{{ route('home') }}" class="logo-link">
                    <div class="logo-wrapper">
                        <div class="logo-icon-wrapper">
                            <span class="logo-icon">🎓</span>
                            <div class="logo-glow"></div>
                        </div>
                        <div class="logo-text-section">
                            <span class="logo-text">AI Learning Platform</span>
                            <span class="logo-subtext">Smart Education System</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="nav-main">
                <div class="nav-links">
                    <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'nav-item-active' : '' }}">
                        <span class="nav-icon">🏠</span>
                        <span class="nav-label">Home</span>
                    </a>
                    <a href="{{ route('courses') }}" class="nav-item {{ request()->routeIs('courses*') ? 'nav-item-active' : '' }}">
                        <span class="nav-icon">📚</span>
                        <span class="nav-label">Courses</span>
                    </a>
                    <a href="{{ route('learn') }}" class="nav-item {{ request()->routeIs('learn*') ? 'nav-item-active' : '' }}">
                        <span class="nav-icon">🎯</span>
                        <span class="nav-label">Learning Path</span>
                    </a>
                    <a href="{{ route('assessments') }}" class="nav-item {{ request()->routeIs('assessments*') ? 'nav-item-active' : '' }}">
                        <span class="nav-icon">📝</span>
                        <span class="nav-label">Assessments</span>
                    </a>
                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'nav-item-active' : '' }}">
                        <span class="nav-icon">📊</span>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </div>
            </div>

            <div class="nav-user">
                @auth('student')
                    <div class="user-profile">
                        <div class="user-avatar">
                            <span class="avatar-text">{{ strtoupper(substr(auth('student')->user()->name, 0, 1)) }}</span>
                            <div class="avatar-online"></div>
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ auth('student')->user()->name }}</span>
                            <span class="user-role">Learner</span>
                        </div>
                        <div class="user-actions">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout-btn">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="auth-section">
                        <a href="{{ route('login') }}" class="auth-btn login-btn">
                            <span class="auth-icon">🔑</span>
                            <span>Log In</span>
                        </a>
                        <a href="{{ route('register') }}" class="auth-btn signup-btn">
                            <span class="auth-icon">✨</span>
                            <span>Sign Up</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-main">
                <div class="footer-brand">
                    <div class="logo">
                        <span class="logo-icon">🎓</span>
                        <span class="logo-text">AI Learning Platform</span>
                    </div>
                    <p class="footer-description">
                        Smart education system for engineering colleges with AI-powered learning.
                    </p>
                </div>
                <div class="footer-links">
                    <div class="link-group">
                        <h4>Platform</h4>
                        <a href="{{ route('courses') }}">Courses</a>
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                        <a href="{{ route('assessments') }}">Assessments</a>
                        <a href="{{ route('progress') }}">Progress</a>
                    </div>
                    <div class="link-group">
                        <h4>Support</h4>
                        <a href="{{ route('help') }}">Help Center</a>
                        <a href="{{ route('contact') }}">Contact Us</a>
                        <a href="{{ route('privacy') }}">Privacy Policy</a>
                        <a href="{{ route('terms') }}">Terms of Service</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© {{ date('Y') }} AI Learning Platform. Smart Education System for Engineering Colleges.</p>
                <div class="tech-info">
                    <span>System Status: Operational</span>
                    <span>AI Assistant: Online 🤖</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/js/app.js'])
    @endif
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
