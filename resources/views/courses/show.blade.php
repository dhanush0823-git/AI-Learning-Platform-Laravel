@extends('layouts.app')

@section('title', ($course->title ?? 'Course') . ' - AI Learning Platform')

@section('content')

<div style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); min-height: 100vh; padding: 40px 24px; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;">
  <div style="max-width: 1000px; margin: 0 auto;">

    {{-- ── Back Link ── --}}
    <a href="{{ route('courses', [], false) }}"
      style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: #4285F4; text-decoration: none; margin-bottom: 28px; padding: 7px 14px; border-radius: 8px; background: rgba(66,133,244,.08); transition: background .15s;"
      onmouseover="this.style.background='rgba(66,133,244,.16)';"
      onmouseout="this.style.background='rgba(66,133,244,.08)';">
      ← Back to Courses
    </a>

    {{-- ── Course Hero Card ── --}}
    <div style="background: #fff; border: 1px solid #eaeaea; border-radius: 20px; overflow: hidden; margin-bottom: 28px; box-shadow: 0 4px 20px rgba(0,0,0,.06);">

      {{-- Gradient stripe --}}
      <div style="height: 5px; background: linear-gradient(90deg, #4285F4 0%, #34A853 100%);"></div>

      <div style="padding: 28px 32px;">
        <div style="display: flex; justify-content: space-between; gap: 24px; flex-wrap: wrap; align-items: flex-start;">

          {{-- Left: title + description --}}
          <div style="flex: 1; min-width: 260px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(66,133,244,.08); border: 1px solid rgba(66,133,244,.2); border-radius: 999px; padding: 4px 12px; margin-bottom: 14px;">
              <span style="font-size: 14px;">🎓</span>
              <span style="font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #4285F4;">Course Overview</span>
            </div>
            <h1 style="font-size: clamp(1.4rem, 3vw, 2rem); font-weight: 800; color: #1a1a1a; margin: 0 0 10px; line-height: 1.2;">
              {{ $course->title }}
            </h1>
            <p style="font-size: 15px; color: #666; margin: 0; line-height: 1.65; max-width: 560px;">
              {{ $course->description }}
            </p>
          </div>

          {{-- Right: meta pills --}}
          <div style="display: flex; flex-direction: column; gap: 10px; align-items: flex-end; flex-shrink: 0;">

            @php
              $level = strtolower($course->difficulty ?? 'beginner');
              $badge = match($level) {
                'beginner'     => ['bg' => '#e6f4ea', 'color' => '#186f36', 'dot' => '#34A853', 'border' => '#b7dfc4'],
                'intermediate' => ['bg' => '#fff8e1', 'color' => '#92400e', 'dot' => '#f59e0b', 'border' => '#fde68a'],
                'advanced'     => ['bg' => '#fde8e8', 'color' => '#991b1b', 'dot' => '#ef4444', 'border' => '#fca5a5'],
                default        => ['bg' => '#e8f0fe', 'color' => '#1a56db', 'dot' => '#4285F4', 'border' => '#bfdbfe'],
              };
            @endphp

            <div style="display: flex; flex-direction: column; gap: 8px;">
              <div style="display: flex; align-items: center; gap: 8px; background: #f8f9fa; border: 1px solid #eaeaea; border-radius: 10px; padding: 10px 16px;">
                <span style="font-size: 16px;">🏢</span>
                <div>
                  <div style="font-size: 10px; color: #aaa; font-weight: 600; letter-spacing: .1em; text-transform: uppercase;">Department</div>
                  <div style="font-size: 15px; font-weight: 800; color: #1a1a1a;">{{ $course->department->code ?? '—' }}</div>
                </div>
              </div>

              <span style="display: inline-flex; align-items: center; gap: 6px; background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; border: 1px solid {{ $badge['border'] }}; font-size: 11px; font-weight: 700; letter-spacing: .08em; padding: 7px 14px; border-radius: 10px; text-transform: uppercase; align-self: stretch; justify-content: center;">
                <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $badge['dot'] }};"></span>
                {{ ucfirst($level) }} Level
              </span>

              @if($course->duration)
                <div style="display: flex; align-items: center; gap: 8px; background: #f8f9fa; border: 1px solid #eaeaea; border-radius: 10px; padding: 10px 16px;">
                  <span style="font-size: 16px;">🕐</span>
                  <div>
                    <div style="font-size: 10px; color: #aaa; font-weight: 600; letter-spacing: .1em; text-transform: uppercase;">Duration</div>
                    <div style="font-size: 14px; font-weight: 700; color: #1a1a1a;">{{ $course->duration }}</div>
                  </div>
                </div>
              @endif
            </div>

          </div>
        </div>

        {{-- Stats bar --}}
        <div style="display: flex; gap: 24px; margin-top: 24px; padding-top: 20px; border-top: 1px solid #f0f0f0; flex-wrap: wrap;">
          <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 20px;">📦</span>
            <div>
              <div style="font-size: 20px; font-weight: 800; color: #1a1a1a; line-height: 1;">{{ $course->modules->count() }}</div>
              <div style="font-size: 11px; color: #aaa; font-weight: 500;">Modules</div>
            </div>
          </div>
          <div style="width: 1px; background: #eaeaea;"></div>
          <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 20px;">📝</span>
            <div>
              <div style="font-size: 20px; font-weight: 800; color: #1a1a1a; line-height: 1;">{{ $course->modules->sum(fn($m) => $m->lessons->count()) }}</div>
              <div style="font-size: 11px; color: #aaa; font-weight: 500;">Total Lessons</div>
            </div>
          </div>
          @if($course->modules->isNotEmpty())
            <div style="width: 1px; background: #eaeaea;"></div>
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 20px;">🎯</span>
              <div>
                <div style="font-size: 20px; font-weight: 800; color: #1a1a1a; line-height: 1;">
                  {{ $course->modules->flatMap->lessons->groupBy('lesson_type')->keys()->count() }}
                </div>
                <div style="font-size: 11px; color: #aaa; font-weight: 500;">Lesson Types</div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>

    {{-- ── Modules Section ── --}}
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px;">
      <h2 style="font-size: 20px; font-weight: 800; color: #1a1a1a; margin: 0;">Course Modules</h2>
      <span style="background: linear-gradient(135deg, #4285F4, #34A853); color: #fff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px;">
        {{ $course->modules->count() }}
      </span>
      <div style="flex: 1; height: 1px; background: #eaeaea;"></div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 14px;">
      @forelse($course->modules as $module)
        @php
          $lessonCount = $module->lessons->count();
          $typeColors = [
            'video'   => ['bg' => '#e8f0fe', 'color' => '#1a56db', 'icon' => '🎬'],
            'quiz'    => ['bg' => '#fff8e1', 'color' => '#92400e', 'icon' => '✏️'],
            'reading' => ['bg' => '#e6f4ea', 'color' => '#186f36', 'icon' => '📖'],
            'lab'     => ['bg' => '#fde8e8', 'color' => '#991b1b', 'icon' => '🔬'],
          ];
        @endphp

        <div style="background: #fff; border: 1px solid #eaeaea; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04); transition: all .2s ease;"
          onmouseover="this.style.boxShadow='0 8px 24px rgba(66,133,244,.1)'; this.style.borderColor='rgba(66,133,244,.3)';"
          onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.04)'; this.style.borderColor='#eaeaea';">

          {{-- Module Header --}}
          <div style="padding: 18px 22px; display: flex; justify-content: space-between; align-items: center; gap: 16px; border-bottom: {{ $lessonCount > 0 ? '1px solid #f4f4f4' : 'none' }}; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 14px; flex: 1; min-width: 200px;">
              {{-- Module number badge --}}
              <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(66,133,244,.25);">
                <span style="font-size: 15px; font-weight: 800; color: #fff;">{{ $module->module_number }}</span>
              </div>
              <div>
                <h3 style="font-size: 15px; font-weight: 700; color: #1a1a1a; margin: 0 0 3px; line-height: 1.3;">
                  {{ $module->title }}
                </h3>
                @if($module->description)
                  <p style="font-size: 13px; color: #888; margin: 0; line-height: 1.5;">{{ $module->description }}</p>
                @endif
              </div>
            </div>
            <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
              <span style="font-size: 14px;">📝</span>
              <span style="font-size: 13px; font-weight: 600; color: #555;">{{ $lessonCount }} lesson{{ $lessonCount !== 1 ? 's' : '' }}</span>
              @auth('student')
                @if($lessonCount > 0)
                  <a href="{{ route('learn.module.start', ['courseId' => $course->id, 'moduleId' => $module->id], false) }}"
                    style="margin-left: 8px; padding: 7px 12px; border-radius: 8px; background: #2563eb; color: #fff; text-decoration: none; font-size: 12px; font-weight: 700;">
                    Start
                  </a>
                @endif
              @endauth
            </div>
          </div>

          {{-- Lessons List --}}
          @if($module->lessons->isNotEmpty())
            <div style="padding: 8px 0;">
              @foreach($module->lessons as $lesson)
                @php
                  $type = strtolower($lesson->lesson_type ?? 'video');
                  $tc   = $typeColors[$type] ?? ['bg' => '#f1f5f9', 'color' => '#475569', 'icon' => '📄'];
                @endphp

                <a href="{{ auth('student')->check() ? route('learn.lesson', ['courseId' => $course->id, 'moduleId' => $module->id, 'lessonId' => $lesson->id], false) : route('courses.lessons.show', ['courseId' => $course->id, 'moduleId' => $module->id, 'lessonId' => $lesson->id], false) }}"
                  style="display: flex; align-items: center; gap: 14px; padding: 11px 22px; border-bottom: 1px solid #fafafa; transition: background .15s; text-decoration: none; color: inherit;"
                  onmouseover="this.style.background='#fafbff';"
                  onmouseout="this.style.background='';">

                  {{-- Lesson number --}}
                  <div style="width: 28px; height: 28px; border-radius: 8px; background: #f4f4f4; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <span style="font-size: 11px; font-weight: 700; color: #aaa;">{{ $lesson->lesson_number }}</span>
                  </div>

                  {{-- Title --}}
                  <div style="font-size: 14px; color: #1a1a1a; font-weight: 500; flex: 1;">
                    <div>{{ $lesson->title }}</div>
                    @if(! empty($lesson->content))
                      <div style="margin-top: 6px; color: #6b7280; font-size: 13px; line-height: 1.6;">
                        {!! \Illuminate\Support\Str::markdown($lesson->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
                      </div>
                    @endif
                  </div>

                  {{-- Type badge --}}
                  <span style="display: inline-flex; align-items: center; gap: 4px; background: {{ $tc['bg'] }}; color: {{ $tc['color'] }}; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 999px; white-space: nowrap; flex-shrink: 0;">
                    {{ $tc['icon'] }} {{ ucfirst($lesson->lesson_type) }}
                  </span>
                </a>
              @endforeach
            </div>
          @endif

        </div>

      @empty
        <div style="background: #fff; border: 1px dashed #ddd; border-radius: 16px; padding: 64px 20px; text-align: center;">
          <div style="font-size: 48px; margin-bottom: 14px;">📭</div>
          <h3 style="font-size: 17px; font-weight: 700; color: #1a1a1a; margin: 0 0 8px;">No modules yet</h3>
          <p style="font-size: 14px; color: #888; margin: 0;">Course modules will appear here once they've been added.</p>
        </div>
      @endforelse
    </div>

  </div>
</div>

@endsection

