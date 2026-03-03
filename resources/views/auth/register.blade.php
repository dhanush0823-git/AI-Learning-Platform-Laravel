<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - AI Learning Platform</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}" type="image/x-icon">
  <style>
    body { font-family: 'Inter', system-ui, sans-serif; }
    .gradient-bg { background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 50%, #f0fff4 100%); }
    .input-focus:focus {
      border-color: #4285F4;
      box-shadow: 0 0 0 3px rgba(66,133,244,0.12);
      outline: none;
    }
    .select-focus:focus {
      border-color: #4285F4;
      box-shadow: 0 0 0 3px rgba(66,133,244,0.12);
      outline: none;
    }
    .btn-gradient {
      background: linear-gradient(135deg, #4285F4 0%, #34A853 100%);
      transition: all 0.2s ease;
    }
    .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(66,133,244,0.4); }
    .btn-gradient:active { transform: translateY(0); }
    .card-shadow { box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.04); }
    .dot-pattern {
      background-image: radial-gradient(circle, #d1e3ff 1px, transparent 1px);
      background-size: 24px 24px;
    }
    @keyframes float {
      0%,100% { transform: translateY(0px); }
      50%      { transform: translateY(-8px); }
    }
    .float-anim       { animation: float 4s ease-in-out infinite; }
    .float-anim-delay { animation: float 4s ease-in-out infinite 1.5s; }
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(20px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .fade-up   { animation: fadeUp 0.5s ease both; }
    .fade-up-1 { animation: fadeUp 0.5s ease 0.05s both; }
    .fade-up-2 { animation: fadeUp 0.5s ease 0.10s both; }
    .fade-up-3 { animation: fadeUp 0.5s ease 0.15s both; }
    .fade-up-4 { animation: fadeUp 0.5s ease 0.20s both; }
    .fade-up-5 { animation: fadeUp 0.5s ease 0.25s both; }
    .fade-up-6 { animation: fadeUp 0.5s ease 0.30s both; }
    .fade-up-7 { animation: fadeUp 0.5s ease 0.35s both; }

    /* Password strength bar */
    .strength-bar { height: 4px; border-radius: 999px; transition: width 0.4s ease, background 0.4s ease; }

    /* Custom select arrow */
    select {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%234285F4'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 14px center;
      -webkit-appearance: none;
      appearance: none;
    }

    /* Step indicator active */
    .step-active { background: linear-gradient(135deg,#4285F4,#34A853); color: white; }
    .step-done   { background: #34A853; color: white; }
    .step-idle   { background: #f1f5f9; color: #94a3b8; }
  </style>
</head>
<body class="gradient-bg min-h-screen">

  <!-- Background decorations -->
  <div class="fixed inset-0 dot-pattern opacity-40 pointer-events-none"></div>
  <div class="fixed top-0 left-0 w-96 h-96 rounded-full opacity-10 pointer-events-none"
       style="background:radial-gradient(circle,#34A853,transparent);transform:translate(-30%,-30%)"></div>
  <div class="fixed bottom-0 right-0 w-80 h-80 rounded-full opacity-10 pointer-events-none"
       style="background:radial-gradient(circle,#4285F4,transparent);transform:translate(30%,30%)"></div>

  <!-- Top Nav -->
  <nav class="relative z-10 px-6 py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
      <div class="flex items-center gap-2.5">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-base btn-gradient">🎓</div>
        <div>
          <span class="text-base font-extrabold text-gray-900">AI Learning</span>
          <span class="text-xs text-gray-400 block leading-none -mt-0.5">Platform</span>
        </div>
      </div>
      <a href="#" class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">Need help?</a>
    </div>
  </nav>

  <!-- Main -->
  <div class="relative z-10 flex min-h-[calc(100vh-72px)]">

    <!-- Left Panel -->
    <div class="hidden lg:flex lg:w-1/2 flex-col justify-center px-16 py-12">
      <div class="max-w-md">

        <div class="inline-flex items-center gap-2 bg-green-50 border border-green-100 rounded-full px-3 py-1.5 mb-8 fade-up">
          <span class="w-2 h-2 rounded-full bg-green-500"></span>
          <span class="text-xs font-bold tracking-widest text-green-600 uppercase">Join 1,000+ Engineers</span>
        </div>

        <h1 class="text-4xl font-extrabold text-gray-900 mb-5 fade-up-1" style="line-height:1.15">
          Start Your<br/>
          <span style="background:linear-gradient(135deg,#4285F4,#34A853);-webkit-background-clip:text;-webkit-text-fill-color:transparent">
            Learning Journey
          </span>
        </h1>
        <p class="text-gray-500 text-base leading-relaxed mb-10 fade-up-2">
          Create your free account and get instant access to department-specific courses, AI-powered learning paths, and progress tracking.
        </p>

        <!-- Steps preview -->
        <div class="space-y-4 mb-10 fade-up-3">
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0 step-active">1</div>
            <div class="pt-0.5">
              <p class="text-sm font-semibold text-gray-800 leading-none">Create your profile</p>
              <p class="text-xs text-gray-400 mt-1">Enter your name, email and department</p>
            </div>
          </div>
          <div class="w-px h-4 bg-gray-200 ml-4"></div>
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0 step-idle">2</div>
            <div class="pt-0.5">
              <p class="text-sm font-semibold text-gray-800 leading-none">Pick your level</p>
              <p class="text-xs text-gray-400 mt-1">Choose your skill level and batch</p>
            </div>
          </div>
          <div class="w-px h-4 bg-gray-200 ml-4"></div>
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0 step-idle">3</div>
            <div class="pt-0.5">
              <p class="text-sm font-semibold text-gray-800 leading-none">Start learning</p>
              <p class="text-xs text-gray-400 mt-1">Access 1000+ lessons instantly</p>
            </div>
          </div>
        </div>

        <!-- Stat cards -->
        <div class="flex gap-4 fade-up-4">
          <div class="bg-white border border-gray-200 rounded-2xl px-4 py-4 card-shadow float-anim flex-1 text-center">
            <div class="text-xl font-extrabold text-blue-600">Free</div>
            <div class="text-xs text-gray-400 font-medium mt-0.5">Always</div>
          </div>
          <div class="bg-white border border-gray-200 rounded-2xl px-4 py-4 card-shadow float-anim-delay flex-1 text-center">
            <div class="text-xl font-extrabold text-green-600">5 Depts</div>
            <div class="text-xs text-gray-400 font-medium mt-0.5">Available</div>
          </div>
          <div class="bg-white border border-gray-200 rounded-2xl px-4 py-4 card-shadow float-anim flex-1 text-center">
            <div class="text-xl font-extrabold text-purple-600">AI</div>
            <div class="text-xs text-gray-400 font-medium mt-0.5">Powered</div>
          </div>
        </div>

      </div>
    </div>

    <!-- Right Panel: Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-10">
      <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl p-8 card-shadow border border-gray-100 fade-up">

          <!-- Top accent -->
          <div class="h-1 rounded-full mb-7 btn-gradient"></div>

          <!-- Header -->
          <div class="mb-6">
            <h2 class="text-2xl font-extrabold text-gray-900 leading-tight">Create your account ✨</h2>
            <p class="text-sm text-gray-400 mt-1.5">Join as a student and start learning for free</p>
          </div>

          <!-- Error block (Laravel) -->
          @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
              <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Please fix the following:</p>
              <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                  <li class="text-xs text-red-600">{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div id="errorBlock" class="hidden bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
            <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Please fix the following:</p>
            <ul id="errorList" class="list-disc list-inside space-y-0.5 text-xs text-red-600"></ul>
          </div>

          <!-- Form -->
          <form id="registerForm" action="{{ route('register') }}" method="POST" class="space-y-4" novalidate>
            @csrf

            <!-- Full Name -->
            <div class="fade-up-1">
              <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Full Name</label>
              <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Arjun Sharma"
                  class="input-focus w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 placeholder-gray-400 transition-all"
                  required/>
              </div>
            </div>

            <!-- Email -->
            <div class="fade-up-2">
              <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Email Address</label>
              <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="you@college.edu"
                  class="input-focus w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 placeholder-gray-400 transition-all"
                  required/>
              </div>
            </div>

            <!-- Department + Level (2 col) -->
            <div class="grid grid-cols-2 gap-3 fade-up-3">
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Department</label>
                <div class="relative">
                  <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                  </svg>
                  <select name="department_id" id="department_id"
                    class="select-focus w-full pl-9 pr-8 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 cursor-pointer transition-all"
                    required>
                    <option value="">Select dept</option>
                    @foreach ($departments as $department)
                      <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                        {{ $department->code }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Level</label>
                <div class="relative">
                  <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                  </svg>
                  <select name="level" id="level"
                    class="select-focus w-full pl-9 pr-8 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 cursor-pointer transition-all"
                    required>
                    <option value="beginner" @selected(old('level') === 'beginner')>Beginner</option>
                    <option value="intermediate" @selected(old('level') === 'intermediate')>Intermediate</option>
                    <option value="advanced" @selected(old('level') === 'advanced')>Advanced</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Batch -->
            <div class="fade-up-4">
              <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Batch Year</label>
              <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <input type="text" name="batch" id="batch" value="{{ old('batch') }}" placeholder="e.g. 2026"
                  maxlength="4"
                  class="input-focus w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 placeholder-gray-400 transition-all"
                  required/>
              </div>
            </div>

            <!-- Password -->
            <div class="fade-up-5">
              <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Password</label>
              <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <input id="password" type="password" name="password" placeholder="Min. 8 characters"
                  class="input-focus w-full pl-10 pr-11 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 placeholder-gray-400 transition-all"
                  required oninput="checkStrength(this.value)"/>
                <button type="button" onclick="togglePwd('password','eyeIcon1')"
                  class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                  <svg id="eyeIcon1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                </button>
              </div>
              <!-- Strength indicator -->
              <div class="mt-2 flex gap-1">
                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden"><div id="bar1" class="strength-bar w-0"></div></div>
                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden"><div id="bar2" class="strength-bar w-0"></div></div>
                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden"><div id="bar3" class="strength-bar w-0"></div></div>
                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden"><div id="bar4" class="strength-bar w-0"></div></div>
              </div>
              <p id="strengthLabel" class="text-xs text-gray-400 mt-1"></p>
            </div>

            <!-- Confirm Password -->
            <div class="fade-up-6">
              <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Confirm Password</label>
              <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Re-enter password"
                  class="input-focus w-full pl-10 pr-11 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 placeholder-gray-400 transition-all"
                  required oninput="checkMatch()"/>
                <button type="button" onclick="togglePwd('password_confirmation','eyeIcon2')"
                  class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                  <svg id="eyeIcon2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                </button>
                <span id="matchIcon" class="absolute right-10 top-1/2 -translate-y-1/2 text-sm hidden"></span>
              </div>
              <p id="matchLabel" class="text-xs mt-1 hidden"></p>
            </div>

            <!-- Terms -->
            <div class="flex items-start gap-2.5 fade-up-7">
              <input type="checkbox" id="terms" name="terms"
                class="w-4 h-4 mt-0.5 rounded border-gray-300 accent-blue-500 cursor-pointer flex-shrink-0" required/>
              <label for="terms" class="text-xs text-gray-500 cursor-pointer leading-relaxed">
                I agree to the
                <a href="#" class="text-blue-500 font-semibold hover:underline">Terms of Service</a>
                and
                <a href="#" class="text-blue-500 font-semibold hover:underline">Privacy Policy</a>
              </label>
            </div>

            <!-- Submit -->
            <button type="submit"
              class="w-full btn-gradient text-white font-bold py-3.5 rounded-xl text-sm tracking-wide shadow-lg fade-up-7">
              Create Account →
            </button>

          </form>

          <!-- Footer -->
          <p class="text-center text-sm text-gray-400 mt-5">
            Already have an account?
            <a href="/login" class="font-semibold text-blue-500 hover:text-blue-700 transition-colors ml-1">Sign in</a>
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
            Free Forever
          </div>
        </div>

      </div>
    </div>
  </div>

  <script>
    // ── Toggle password visibility ──────────────────────
    function togglePwd(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon  = document.getElementById(iconId);
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      icon.innerHTML = isHidden
        ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
        : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }

    // ── Password strength ───────────────────────────────
    function checkStrength(val) {
      let score = 0;
      if (val.length >= 8)              score++;
      if (/[A-Z]/.test(val))            score++;
      if (/[0-9]/.test(val))            score++;
      if (/[^A-Za-z0-9]/.test(val))     score++;

      const colors = ['', '#ef4444','#f59e0b','#3b82f6','#22c55e'];
      const labels = ['', 'Weak','Fair','Good','Strong'];
      const labelColors = ['','text-red-500','text-amber-500','text-blue-500','text-green-500'];

      for (let i = 1; i <= 4; i++) {
        const bar = document.getElementById('bar' + i);
        bar.style.width = i <= score ? '100%' : '0%';
        bar.style.background = i <= score ? colors[score] : '';
      }

      const lbl = document.getElementById('strengthLabel');
      lbl.textContent = val.length ? labels[score] : '';
      lbl.className = 'text-xs mt-1 ' + (val.length ? labelColors[score] : 'text-gray-400');
    }

    // ── Password match ──────────────────────────────────
    function checkMatch() {
      const pwd   = document.getElementById('password').value;
      const conf  = document.getElementById('password_confirmation').value;
      const lbl   = document.getElementById('matchLabel');
      const icon  = document.getElementById('matchIcon');
      const input = document.getElementById('password_confirmation');

      if (!conf) { lbl.classList.add('hidden'); icon.classList.add('hidden'); return; }

      if (pwd === conf) {
        lbl.textContent = 'Passwords match ✓';
        lbl.className = 'text-xs mt-1 text-green-500';
        lbl.classList.remove('hidden');
        input.style.borderColor = '#22c55e';
      } else {
        lbl.textContent = 'Passwords do not match';
        lbl.className = 'text-xs mt-1 text-red-500';
        lbl.classList.remove('hidden');
        input.style.borderColor = '#ef4444';
      }
    }

    // ── Client-side validation ──────────────────────────
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      const errors = [];
      const name   = document.getElementById('name').value.trim();
      const email  = document.getElementById('email').value.trim();
      const dept   = document.getElementById('department_id').value;
      const batch  = document.getElementById('batch').value.trim();
      const pwd    = document.getElementById('password').value;
      const conf   = document.getElementById('password_confirmation').value;
      const terms  = document.getElementById('terms').checked;

      if (!name)                                   errors.push('Full name is required.');
      if (!email || !/\S+@\S+\.\S+/.test(email)) errors.push('A valid email address is required.');
      if (!dept)                                   errors.push('Please select your department.');
      if (!batch || !/^\d{4}$/.test(batch))        errors.push('Enter a valid 4-digit batch year.');
      if (pwd.length < 8)                          errors.push('Password must be at least 8 characters.');
      if (pwd !== conf)                            errors.push('Passwords do not match.');
      if (!terms)                                  errors.push('You must agree to the Terms of Service.');

      if (errors.length) {
        e.preventDefault();
        const block = document.getElementById('errorBlock');
        const list  = document.getElementById('errorList');
        list.innerHTML = errors.map(err => `<li>${err}</li>`).join('');
        block.classList.remove('hidden');
        block.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  </script>

</body>
</html>
