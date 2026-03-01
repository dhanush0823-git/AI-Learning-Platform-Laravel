{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'AI Learning Platform - Home')

@section('content')

<div style="min-height: 100vh; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;">

  {{-- ══════════════════════════════════════
       HERO SECTION
  ══════════════════════════════════════ --}}
  <section style="background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%); padding: 90px 24px 80px; border-bottom: 1px solid #eaeaea;">
    <div style="max-width: 1200px; margin: 0 auto;">

      {{-- Hero Text --}}
      <div style="text-align: center; margin-bottom: 64px;">
        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(66,133,244,.08); border: 1px solid rgba(66,133,244,.2); border-radius: 999px; padding: 6px 16px; margin-bottom: 24px;">
          <span style="font-size: 14px;">🤖</span>
          <span style="font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #4285F4;">AI-Powered Learning</span>
        </div>
        <h1 style="font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 800; line-height: 1.15; margin: 0 0 20px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
          Smart Education System for<br>Engineering Colleges
        </h1>
        <p style="font-size: clamp(1rem, 2vw, 1.15rem); color: #666; max-width: 680px; margin: 0 auto 40px; line-height: 1.7;">
          AI-powered personalized learning paths, department-specific courses, and real-time progress tracking for engineering students.
        </p>
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
          @auth('student')
            <a href="{{ route('dashboard') }}"
              style="padding: 15px 36px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; box-shadow: 0 6px 20px rgba(66,133,244,.28); display: inline-block; transition: all .2s;"
              onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 28px rgba(66,133,244,.38)';"
              onmouseout="this.style.transform=''; this.style.boxShadow='0 6px 20px rgba(66,133,244,.28)';">
              Continue Learning →
            </a>
          @else
            <a href="{{ route('register') }}"
              style="padding: 15px 36px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; box-shadow: 0 6px 20px rgba(66,133,244,.28); display: inline-block;"
              onmouseover="this.style.transform='translateY(-3px)';"
              onmouseout="this.style.transform='';">
              Get Started Free
            </a>
            <a href="#foundation-courses"
              style="padding: 15px 36px; border: 2px solid #4285F4; color: #4285F4; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; background: white; display: inline-block;"
              onmouseover="this.style.background='#4285F4'; this.style.color='white'; this.style.transform='translateY(-3px)';"
              onmouseout="this.style.background='white'; this.style.color='#4285F4'; this.style.transform='';">
              Explore Courses
            </a>
          @endauth
        </div>
      </div>

      {{-- Stats Row --}}
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; max-width: 760px; margin: 0 auto;">
        @foreach([['5+', 'Engineering Departments', '🏛️'], ['25+', 'Structured Courses', '📚'], ['1000+', 'Interactive Lessons', '⚡']] as [$num, $label, $icon])
          <div style="background: white; border: 1px solid #eaeaea; border-radius: 16px; padding: 28px 20px; text-align: center; box-shadow: 0 6px 20px rgba(0,0,0,.06); transition: all .2s;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 32px rgba(66,133,244,.1)';"
            onmouseout="this.style.transform=''; this.style.boxShadow='0 6px 20px rgba(0,0,0,.06)';">
            <div style="font-size: 28px; margin-bottom: 8px;">{{ $icon }}</div>
            <div style="font-size: 2.4rem; font-weight: 800; color: #4285F4; line-height: 1; margin-bottom: 8px;">{{ $num }}</div>
            <div style="font-size: 13px; color: #888; font-weight: 600;">{{ $label }}</div>
          </div>
        @endforeach
      </div>

    </div>
  </section>

  {{-- ══════════════════════════════════════
       DEPARTMENTS SECTION
  ══════════════════════════════════════ --}}
  <section style="padding: 80px 24px; background: white;">
    <div style="max-width: 1200px; margin: 0 auto;">

      <div style="text-align: center; margin-bottom: 52px;">
        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(52,168,83,.08); border: 1px solid rgba(52,168,83,.2); border-radius: 999px; padding: 5px 14px; margin-bottom: 14px;">
          <span style="font-size: 12px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #34A853;">Departments</span>
        </div>
        <h2 style="font-size: clamp(1.6rem, 3.5vw, 2.6rem); font-weight: 800; color: #1a1a1a; margin: 0 0 12px;">Choose Your Department</h2>
        <p style="color: #666; font-size: 1rem; max-width: 500px; margin: 0 auto; line-height: 1.6;">
          Access department-specific courses tailored to your engineering field
        </p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 32px;">
        @foreach($displayDepartments as $dept)
          <div style="background: white; border: 1px solid #eaeaea; border-top: 4px solid {{ $dept->color }}; border-radius: 14px; padding: 28px 20px; text-align: center; cursor: pointer; box-shadow: 0 3px 12px rgba(0,0,0,.05); transition: all .2s; display: flex; flex-direction: column; align-items: center; gap: 12px;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 28px rgba(0,0,0,.1)';"
            onmouseout="this.style.transform=''; this.style.boxShadow='0 3px 12px rgba(0,0,0,.05)';">
            <div style="font-size: 2.4rem; transition: transform .2s;"
              onmouseover="this.style.transform='scale(1.1)';"
              onmouseout="this.style.transform='';">
              {{ $dept->icon }}
            </div>
            <div>
              <div style="font-size: 1.3rem; font-weight: 800; color: #1a1a1a; margin-bottom: 4px;">{{ $dept->code }}</div>
              <div style="font-size: 12px; color: #888; line-height: 1.4; margin-bottom: 12px;">{{ $dept->name }}</div>
            </div>
            <span style="background: rgba(66,133,244,.1); color: #4285F4; border: 1px solid rgba(66,133,244,.2); padding: 5px 14px; border-radius: 999px; font-size: 12px; font-weight: 600;">
              {{ $dept->courses_count ?? 5 }}+ Courses
            </span>
          </div>
        @endforeach
      </div>

      <div style="text-align: center;">
        <a href="{{ route('courses') }}"
          style="display: inline-block; padding: 12px 28px; background: #f8f9fa; color: #555; border: 2px solid #eaeaea; border-radius: 10px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all .2s;"
          onmouseover="this.style.background='#eaeaea'; this.style.transform='translateY(-2px)';"
          onmouseout="this.style.background='#f8f9fa'; this.style.transform='';">
          View All Departments →
        </a>
      </div>

    </div>
  </section>

  {{-- ══════════════════════════════════════
       FOUNDATION COURSES
  ══════════════════════════════════════ --}}
  <section id="foundation-courses" style="padding: 80px 24px; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
    <div style="max-width: 1200px; margin: 0 auto;">

      <div style="text-align: center; margin-bottom: 52px;">
        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(66,133,244,.08); border: 1px solid rgba(66,133,244,.2); border-radius: 999px; padding: 5px 14px; margin-bottom: 14px;">
          <span style="font-size: 12px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #4285F4;">Start Here</span>
        </div>
        <h2 style="font-size: clamp(1.6rem, 3.5vw, 2.6rem); font-weight: 800; color: #1a1a1a; margin: 0 0 12px;">Foundation Courses</h2>
        <p style="color: #666; font-size: 1rem; max-width: 500px; margin: 0 auto; line-height: 1.6;">
          Start your learning journey with these essential beginner courses
        </p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">
        @foreach($foundationCourses as $course)
          <div style="background: white; border: 1px solid #eaeaea; border-radius: 16px; padding: 28px; display: flex; flex-direction: column; gap: 16px; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,.06); transition: all .2s;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 32px rgba(66,133,244,.12)';"
            onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 16px rgba(0,0,0,.06)';">

            {{-- Top gradient stripe --}}
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #4285F4, #34A853);"></div>

            {{-- Course Header --}}
            <div style="display: flex; align-items: center; gap: 14px;">
              <div style="width: 56px; height: 56px; border-radius: 14px; background: rgba(66,133,244,.1); border: 1px solid rgba(66,133,244,.15); display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0;">
                {{ $course->icon ?? '📚' }}
              </div>
              <div style="display: flex; justify-content: space-between; align-items: center; flex: 1; gap: 8px; flex-wrap: wrap;">
                <span style="background: linear-gradient(135deg, #4285F4, #34A853); color: white; padding: 5px 14px; border-radius: 999px; font-size: 11px; font-weight: 700;">
                  {{ $course->department->code }}
                </span>
                <span style="font-size: 12px; color: #aaa;">🕐 {{ $course->duration ?? '4 weeks' }}</span>
              </div>
            </div>

            {{-- Title & Description --}}
            <div>
              <h3 style="font-size: 1.2rem; font-weight: 800; color: #1a1a1a; margin: 0 0 8px; line-height: 1.3;">{{ $course->title }}</h3>
              <p style="font-size: 13.5px; color: #666; line-height: 1.65; margin: 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">{{ $course->description }}</p>
            </div>

            {{-- YouTube Link --}}
            @if($course->youtube_link)
              <div style="background: #fff5f5; border-left: 4px solid #FF0000; border-radius: 8px; padding: 12px 16px;">
                <a href="{{ $course->youtube_link }}" target="_blank" rel="noopener noreferrer"
                  style="display: inline-flex; align-items: center; gap: 8px; color: #cc0000; font-size: 13px; font-weight: 600; text-decoration: none;"
                  onmouseover="this.style.color='#ff0000';"
                  onmouseout="this.style.color='#cc0000';">
                  <span style="background: #FF0000; color: white; border-radius: 5px; padding: 2px 7px; font-size: 11px;">▶ YouTube</span>
                  Watch Tutorial
                </a>
              </div>
            @endif

            {{-- Actions --}}
            <div style="display: flex; gap: 10px; margin-top: auto;">
              <a href="{{ route('courses.show', $course->id) }}"
                style="flex: 1; padding: 11px 16px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; border-radius: 10px; font-weight: 600; font-size: 13px; text-align: center; text-decoration: none; box-shadow: 0 4px 12px rgba(66,133,244,.25); transition: all .2s;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 18px rgba(66,133,244,.35)';"
                onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 12px rgba(66,133,244,.25)';">
                Start Learning →
              </a>
              <button onclick="previewCourse({{ $course->id }})"
                style="padding: 11px 16px; background: #f8f9fa; color: #555; border: 1px solid #eaeaea; border-radius: 10px; font-weight: 500; font-size: 13px; cursor: pointer; transition: all .2s; font-family: inherit;"
                onmouseover="this.style.background='#eaeaea'; this.style.transform='translateY(-2px)';"
                onmouseout="this.style.background='#f8f9fa'; this.style.transform='';">
                Preview
              </button>
            </div>

          </div>
        @endforeach
      </div>

    </div>
  </section>

  {{-- ══════════════════════════════════════
       AI FEATURES SECTION
  ══════════════════════════════════════ --}}
  <section style="padding: 80px 24px; background: white;">
    <div style="max-width: 1200px; margin: 0 auto;">

      <div style="text-align: center; margin-bottom: 52px;">
        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(66,133,244,.08); border: 1px solid rgba(66,133,244,.2); border-radius: 999px; padding: 5px 14px; margin-bottom: 14px;">
          <span style="font-size: 12px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #4285F4;">Why Choose Us</span>
        </div>
        <h2 style="font-size: clamp(1.6rem, 3.5vw, 2.6rem); font-weight: 800; color: #1a1a1a; margin: 0 0 12px;">AI-Powered Learning Features</h2>
        <p style="color: #666; font-size: 1rem; max-width: 500px; margin: 0 auto; line-height: 1.6;">
          Experience next-generation education with our intelligent platform
        </p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 20px;">
        @foreach($aiFeatures as $feature)
          <div style="background: white; border: 1px solid #eaeaea; border-radius: 16px; padding: 32px 24px; text-align: center; box-shadow: 0 4px 14px rgba(0,0,0,.05); transition: all .2s; display: flex; flex-direction: column; align-items: center; gap: 14px; position: relative; overflow: hidden;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 28px rgba(66,133,244,.12)'; this.style.borderColor='rgba(66,133,244,.3)';"
            onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 14px rgba(0,0,0,.05)'; this.style.borderColor='#eaeaea';">
            <div style="width: 64px; height: 64px; border-radius: 18px; background: linear-gradient(135deg, rgba(66,133,244,.12), rgba(52,168,83,.12)); border: 1px solid rgba(66,133,244,.15); display: flex; align-items: center; justify-content: center; font-size: 30px;">
              {{ $feature->icon }}
            </div>
            <h3 style="font-size: 15px; font-weight: 700; color: #1a1a1a; margin: 0;">{{ $feature->title }}</h3>
            <p style="font-size: 13px; color: #888; line-height: 1.6; margin: 0;">{{ $feature->description }}</p>
          </div>
        @endforeach
      </div>

    </div>
  </section>

  {{-- ══════════════════════════════════════
       ALL COURSES SECTION
  ══════════════════════════════════════ --}}
  <section style="padding: 80px 24px; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
    <div style="max-width: 1200px; margin: 0 auto;">

      {{-- Section Header --}}
      <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; flex-wrap: wrap; gap: 20px;">
        <div>
          <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(66,133,244,.08); border: 1px solid rgba(66,133,244,.2); border-radius: 999px; padding: 5px 14px; margin-bottom: 12px;">
            <span style="font-size: 12px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #4285F4;">All Courses</span>
          </div>
          <h2 style="font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color: #1a1a1a; margin: 0 0 6px;">Browse All Courses</h2>
          <p style="color: #888; font-size: 14px; margin: 0;">Choose from 25+ courses across 5 engineering departments</p>
        </div>

        {{-- Difficulty Filter --}}
        <div style="display: flex; flex-direction: column; gap: 8px;">
          <span style="font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #aaa;">Filter by Level</span>
          <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            @foreach([
              ['ALL',          'All Levels', '#4285F4', 'rgba(66,133,244,.08)', 'rgba(66,133,244,.2)'],
              ['beginner',     'Beginner',   '#34A853', 'rgba(52,168,83,.08)',  'rgba(52,168,83,.2)'],
              ['intermediate', 'Intermediate','#FBBC05','rgba(251,188,5,.1)',   'rgba(251,188,5,.3)'],
              ['advanced',     'Advanced',   '#EA4335', 'rgba(234,67,53,.08)',  'rgba(234,67,53,.2)'],
            ] as [$val, $label, $activeColor, $activeBg, $activeBorder])
              @php $isActive = (!request('difficulty') && $val === 'ALL') || request('difficulty') === $val; @endphp
              <a href="{{ route('home', ['difficulty' => $val]) }}"
                style="padding: 8px 16px; border-radius: 999px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all .2s;
                  background: {{ $isActive ? $activeBg : 'white' }};
                  color: {{ $isActive ? $activeColor : '#666' }};
                  border: 1.5px solid {{ $isActive ? $activeBorder : '#eaeaea' }};"
                onmouseover="this.style.transform='translateY(-1px)';"
                onmouseout="this.style.transform='';">
                {{ $label }}
              </a>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Count bar --}}
      <div style="background: white; border: 1px solid #eaeaea; border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 18px; font-weight: 800; color: #1a1a1a;">{{ $courses->count() }}</span>
        <span style="font-size: 14px; color: #aaa;">
          course{{ $courses->count() !== 1 ? 's' : '' }} found
          @if(request('department') && request('department') != 'ALL')
            in <strong style="color: #555;">{{ $departments->where('code', request('department'))->first()->name ?? request('department') }}</strong>
          @endif
          @if(request('difficulty') && request('difficulty') != 'ALL')
            · <strong style="color: #555;">{{ ucfirst(request('difficulty')) }}</strong> level
          @endif
        </span>
        <div style="flex: 1; height: 1px; background: #eaeaea; margin-left: 6px;"></div>
      </div>

      {{-- Courses Grid --}}
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
        @forelse($courses as $index => $course)
          @php
            $level = strtolower($course->difficulty ?? 'beginner');
            $badge = match($level) {
              'beginner'     => ['bg' => '#e6f4ea', 'color' => '#186f36', 'dot' => '#34A853', 'border' => '#b7dfc4'],
              'intermediate' => ['bg' => '#fff8e1', 'color' => '#92400e', 'dot' => '#f59e0b', 'border' => '#fde68a'],
              'advanced'     => ['bg' => '#fde8e8', 'color' => '#991b1b', 'dot' => '#ef4444', 'border' => '#fca5a5'],
              default        => ['bg' => '#e8f0fe', 'color' => '#1a56db', 'dot' => '#4285F4', 'border' => '#bfdbfe'],
            };
            $icons = ['💻','🧠','⚡','🔬','🎯','📊','🤖','📐','🔭','🧬'];
            $icon  = $icons[$index % count($icons)];
          @endphp

          <div style="background: white; border: 1px solid #eaeaea; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 2px 8px rgba(0,0,0,.05); transition: all .2s;"
            onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(66,133,244,.12)'; this.style.borderColor='rgba(66,133,244,.35)';"
            onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,.05)'; this.style.borderColor='#eaeaea';">

            <div style="height: 4px; background: linear-gradient(90deg, #4285F4, #34A853);"></div>

            <div style="padding: 22px; display: flex; flex-direction: column; gap: 14px; flex: 1;">

              <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
                <div style="width: 46px; height: 46px; border-radius: 12px; background: linear-gradient(135deg, rgba(66,133,244,.1), rgba(52,168,83,.1)); border: 1px solid rgba(66,133,244,.15); display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                  {{ $icon }}
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 5px;">
                  <span style="display: inline-flex; align-items: center; gap: 5px; background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; border: 1px solid {{ $badge['border'] }}; font-size: 10px; font-weight: 700; letter-spacing: .08em; padding: 4px 10px; border-radius: 999px; text-transform: uppercase;">
                    <span style="width: 5px; height: 5px; border-radius: 50%; background: {{ $badge['dot'] }};"></span>
                    {{ ucfirst($level) }}
                  </span>
                  @if($course->department)
                    <span style="font-size: 10px; font-weight: 700; color: {{ $course->department->color ?? '#4285F4' }}; background: {{ $course->department->color ?? '#4285F4' }}18; border: 1px solid {{ $course->department->color ?? '#4285F4' }}30; padding: 3px 9px; border-radius: 999px; letter-spacing: .07em;">
                      {{ $course->department->code }}
                    </span>
                  @endif
                </div>
              </div>

              <div>
                <h3 style="font-size: 15px; font-weight: 700; color: #1a1a1a; margin: 0 0 7px; line-height: 1.35;">{{ $course->title }}</h3>
                <p style="font-size: 13px; color: #888; line-height: 1.65; margin: 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">{{ $course->description }}</p>
              </div>

              <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 14px; border-top: 1px solid #f4f4f4; margin-top: auto;">
                <span style="font-size: 12px; color: #aaa;">📦 {{ $course->total_modules ?? 0 }} Modules</span>
                <a href="{{ route('courses.show', $course->id) }}"
                  style="display: inline-flex; align-items: center; gap: 5px; font-size: 13px; font-weight: 600; color: #4285F4; text-decoration: none; padding: 7px 14px; border-radius: 8px; background: rgba(66,133,244,.08); transition: background .15s;"
                  onmouseover="this.style.background='rgba(66,133,244,.16)';"
                  onmouseout="this.style.background='rgba(66,133,244,.08)';">
                  View Details →
                </a>
              </div>

            </div>
          </div>

        @empty
          <div style="grid-column: 1 / -1; background: white; border: 1px dashed #ddd; border-radius: 16px; padding: 64px 20px; text-align: center;">
            <div style="font-size: 52px; margin-bottom: 14px;">🔍</div>
            <h3 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin: 0 0 8px;">No courses found</h3>
            <p style="font-size: 14px; color: #888; margin: 0 0 24px;">Try a different level filter.</p>
            <a href="{{ route('home') }}"
              style="display: inline-block; padding: 11px 24px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px rgba(66,133,244,.3);">
              Reset Filters
            </a>
          </div>
        @endforelse
      </div>

    </div>
  </section>

</div>

@push('scripts')
<script>
  function previewCourse(courseId) {
    alert('Course preview feature coming soon!');
  }
</script>
@endpush

@endsection