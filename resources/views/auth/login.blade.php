<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - AI Learning Platform</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: 'Inter', system-ui, sans-serif; }
    .gradient-bg {
      background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 50%, #f0fff4 100%);
    }
    .input-focus:focus {
      border-color: #4285F4;
      box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.12);
      outline: none;
    }
    .btn-gradient {
      background: linear-gradient(135deg, #4285F4 0%, #34A853 100%);
      transition: all 0.2s ease;
    }
    .btn-gradient:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(66, 133, 244, 0.4);
    }
    .btn-gradient:active { transform: translateY(0); }
    .card-shadow {
      box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.04);
    }
    .dot-pattern {
      background-image: radial-gradient(circle, #d1e3ff 1px, transparent 1px);
      background-size: 24px 24px;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-8px); }
    }
    .float-anim { animation: float 4s ease-in-out infinite; }
    .float-anim-delay { animation: float 4s ease-in-out infinite 1.5s; }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.5s ease both; }
    .fade-up-1 { animation: fadeUp 0.5s ease 0.1s both; }
    .fade-up-2 { animation: fadeUp 0.5s ease 0.2s both; }
    .fade-up-3 { animation: fadeUp 0.5s ease 0.3s both; }
    .fade-up-4 { animation: fadeUp 0.5s ease 0.4s both; }
  </style>
</head>
<body class="gradient-bg min-h-screen">

  <!-- Background decorations -->
  <div class="fixed inset-0 dot-pattern opacity-40 pointer-events-none"></div>
  <div class="fixed top-0 right-0 w-96 h-96 rounded-full opacity-10 pointer-events-none" style="background: radial-gradient(circle, #4285F4, transparent); transform: translate(30%, -30%);"></div>
  <div class="fixed bottom-0 left-0 w-80 h-80 rounded-full opacity-10 pointer-events-none" style="background: radial-gradient(circle, #34A853, transparent); transform: translate(-30%, 30%);"></div>

  <!-- Top nav bar -->
  <nav class="relative z-10 px-6 py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
      <div class="flex items-center gap-2.5">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-base btn-gradient">
          🎓
        </div>
        <div>
          <span class="text-base font-extrabold text-gray-900">AI Learning</span>
          <span class="text-xs text-gray-400 block leading-none -mt-0.5">Platform</span>
        </div>
      </div>
      <a href="#" class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
        Need help?
      </a>
    </div>
  </nav>

  <!-- Main content -->
  <div class="relative z-10 flex min-h-[calc(100vh-72px)]">

    <!-- Left panel (hidden on mobile) -->
    <div class="hidden lg:flex lg:w-1/2 flex-col justify-center px-16 py-12">

      <div class="max-w-md">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-full px-3 py-1.5 mb-8 fade-up">
          <span class="w-2 h-2 rounded-full bg-blue-500"></span>
          <span class="text-xs font-bold tracking-widest text-blue-600 uppercase">AI-Powered Learning</span>
        </div>

        <h1 class="text-4xl font-extrabold text-gray-900 leading-tight mb-5 fade-up-1" style="line-height:1.15">
          Smart Education<br/>
          <span style="background: linear-gradient(135deg, #4285F4, #34A853); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            for Engineers
          </span>
        </h1>
        <p class="text-gray-500 text-base leading-relaxed mb-10 fade-up-2">
          Personalized learning paths, department-specific courses, and real-time progress tracking — all in one platform.
        </p>

        <!-- Feature list -->
        <div class="space-y-4 fade-up-3">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center text-base flex-shrink-0">🧠</div>
            <div>
              <p class="text-sm font-semibold text-gray-800 leading-none">AI-Adaptive Learning</p>
              <p class="text-xs text-gray-400 mt-0.5">Courses that adapt to your skill level</p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-base flex-shrink-0">📊</div>
            <div>
              <p class="text-sm font-semibold text-gray-800 leading-none">Real-time Analytics</p>
              <p class="text-xs text-gray-400 mt-0.5">Track your progress across all courses</p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-purple-100 flex items-center justify-center text-base flex-shrink-0">🏅</div>
            <div>
              <p class="text-sm font-semibold text-gray-800 leading-none">Certifications</p>
              <p class="text-xs text-gray-400 mt-0.5">Earn verified certificates on completion</p>
            </div>
          </div>
        </div>

        <!-- Floating stat cards -->
        <div class="flex gap-4 mt-12 fade-up-4">
          <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 card-shadow float-anim flex-1 text-center">
            <div class="text-2xl font-extrabold text-blue-600">1000+</div>
            <div class="text-xs text-gray-400 font-medium mt-0.5">Lessons</div>
          </div>
          <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 card-shadow float-anim-delay flex-1 text-center">
            <div class="text-2xl font-extrabold text-green-600">5</div>
            <div class="text-xs text-gray-400 font-medium mt-0.5">Departments</div>
          </div>
          <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 card-shadow float-anim flex-1 text-center">
            <div class="text-2xl font-extrabold text-purple-600">25+</div>
            <div class="text-xs text-gray-400 font-medium mt-0.5">Courses</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right panel: Login form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
      <div class="w-full max-w-md">

        <!-- Card -->
        <div class="bg-white rounded-3xl p-8 card-shadow border border-gray-100 fade-up">

          <!-- Card top accent -->
          <div class="h-1 rounded-full mb-8 btn-gradient"></div>

          <!-- Header -->
          <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-gray-900 leading-tight">Welcome back 👋</h2>
            <p class="text-sm text-gray-400 mt-1.5">Sign in to continue your learning journey</p>
          </div>

          <!-- Social login options -->
          <div class="grid grid-cols-2 gap-3 mb-6">
            <button class="flex items-center justify-center gap-2 py-2.5 px-4 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all">
              <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
              Google
            </button>
            <button class="flex items-center justify-center gap-2 py-2.5 px-4 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.298 24 12c0-6.627-5.373-12-12-12"/></svg>
              GitHub
            </button>
          </div>

          <!-- Divider -->
          <div class="flex items-center gap-3 mb-6">
            <div class="flex-1 h-px bg-gray-100"></div>
            <span class="text-xs text-gray-400 font-medium px-1">or continue with email</span>
            <div class="flex-1 h-px bg-gray-100"></div>
          </div>

          @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
              <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Login error</p>
              <p class="text-xs text-red-600">{{ $errors->first() }}</p>
            </div>
          @endif

          <!-- Form -->
          <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Email -->
            <div class="fade-up-1">
              <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Email Address</label>
              <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                </svg>
                <input
                  type="email"
                  name="email"
                  value="{{ old('email') }}"
                  placeholder="you@college.edu"
                  class="input-focus w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 placeholder-gray-400 transition-all"
                  required
                />
              </div>
            </div>

            <!-- Password -->
            <div class="fade-up-2">
              <div class="flex items-center justify-between mb-1.5">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider">Password</label>
                <a href="#" class="text-xs font-semibold text-blue-500 hover:text-blue-700 transition-colors">Forgot password?</a>
              </div>
              <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <input
                  id="passwordInput"
                  type="password"
                  name="password"
                  placeholder="Enter your password"
                  class="input-focus w-full pl-10 pr-11 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 placeholder-gray-400 transition-all"
                  required
                />
                <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                  <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                </button>
              </div>
            </div>

            <!-- Role selector -->
            <div class="fade-up-3">
              <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Login As</label>
              <div class="grid grid-cols-3 gap-2">
                <label class="relative cursor-pointer">
                  <input type="radio" name="role" value="student" class="peer sr-only" {{ old('role', 'student') === 'student' ? 'checked' : '' }}/>
                  <div class="flex flex-col items-center gap-1 p-2.5 rounded-xl border-2 border-gray-200 bg-gray-50 peer-checked:border-blue-400 peer-checked:bg-blue-50 transition-all text-center">
                    <span class="text-lg">🎓</span>
                    <span class="text-xs font-semibold text-gray-600 peer-checked:text-blue-700">Student</span>
                  </div>
                </label>
                <label class="relative cursor-pointer">
                  <input type="radio" name="role" value="faculty" class="peer sr-only" {{ old('role') === 'faculty' ? 'checked' : '' }}/>
                  <div class="flex flex-col items-center gap-1 p-2.5 rounded-xl border-2 border-gray-200 bg-gray-50 peer-checked:border-blue-400 peer-checked:bg-blue-50 transition-all text-center">
                    <span class="text-lg">👨‍🏫</span>
                    <span class="text-xs font-semibold text-gray-600 peer-checked:text-blue-700">Faculty</span>
                  </div>
                </label>
              </div>
            </div>

            <!-- Remember me -->
            <div class="flex items-center gap-2 fade-up-4">
              <input type="checkbox" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 accent-blue-500 cursor-pointer"/>
              <label for="remember" class="text-sm text-gray-500 cursor-pointer select-none">Keep me signed in</label>
            </div>

            <!-- Submit button -->
            <button type="submit"
              class="w-full btn-gradient text-white font-bold py-3.5 rounded-xl text-sm tracking-wide shadow-lg">
              Sign In to Dashboard →
            </button>

          </form>

          <!-- Footer links -->
          <p class="text-center text-sm text-gray-400 mt-6">
            Don't have an account?
            <a href="/register" class="font-semibold text-blue-500 hover:text-blue-700 transition-colors ml-1">Create one free</a>
          </p>

        </div>

        <!-- Trust badges -->
        <div class="flex items-center justify-center gap-6 mt-6 fade-up">
          <div class="flex items-center gap-1.5 text-xs text-gray-400">
            <svg class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            SSL Secured
          </div>
          <div class="flex items-center gap-1.5 text-xs text-gray-400">
            <svg class="w-3.5 h-3.5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"/></svg>
            Privacy Protected
          </div>
          <div class="flex items-center gap-1.5 text-xs text-gray-400">
            <svg class="w-3.5 h-3.5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Verified Platform
          </div>
        </div>

      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('passwordInput');
      const icon  = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
      } else {
        input.type = 'password';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
      }
    }

    // Role selector interaction
    document.querySelectorAll('input[name="role"]').forEach(radio => {
      radio.addEventListener('change', function() {
        document.querySelectorAll('input[name="role"]').forEach(r => {
          const div = r.nextElementSibling;
          if (r.checked) {
            div.classList.add('border-blue-400', 'bg-blue-50');
            div.classList.remove('border-gray-200', 'bg-gray-50');
          } else {
            div.classList.remove('border-blue-400', 'bg-blue-50');
            div.classList.add('border-gray-200', 'bg-gray-50');
          }
        });
      });
    });
  </script>

</body>
</html>
