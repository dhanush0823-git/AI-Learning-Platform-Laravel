@extends('layouts.app')

@section('title', 'Courses - AI Learning Platform')

@section('content')

<div style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); min-height: 100vh; padding: 40px 24px; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;">
  <div style="max-width: 1200px; margin: 0 auto;">

    {{-- ── Page Header ── --}}
    <div style="margin-bottom: 36px;">
      <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(66,133,244,.08); border: 1px solid rgba(66,133,244,.2); border-radius: 999px; padding: 4px 12px; margin-bottom: 14px;">
        <span style="font-size: 14px;">📚</span>
        <span style="font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #4285F4;">Course Catalog</span>
      </div>
      <h1 style="font-size: clamp(1.9rem, 4vw, 2.7rem); font-weight: 800; color: #1a1a1a; margin: 0 0 10px; line-height: 1.1;">
        Browse All Courses
      </h1>
      <p style="font-size: 15px; color: #666; margin: 0; max-width: 500px; line-height: 1.6;">
        Explore courses across departments and skill levels — from foundations to advanced specializations.
      </p>
    </div>

    {{-- ── Filter Card ── --}}
    @if(!Auth::guard('student')->check())
     <div style="background: #fff; border: 1px solid #eaeaea; border-radius: 16px; padding: 20px 24px; margin-bottom: 28px; box-shadow: 0 2px 12px rgba(0,0,0,.05);">
      <form method="GET" action="{{ route('courses', [], false) }}" style="display: flex; flex-wrap: wrap; gap: 14px; align-items: flex-end;">

        <div style="display: flex; flex-direction: column; gap: 6px; flex: 1; min-width: 200px;">
          <label style="font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #aaa;">Department</label>
          <select name="department"
            style="appearance: none; -webkit-appearance: none;
              background-color: #f8f9fa;
              background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2210%22 height=%226%22 viewBox=%220 0 10 6%22><path d=%22M0 0l5 6 5-6z%22 fill=%22%234285F4%22/></svg>');
              background-repeat: no-repeat; background-position: right 14px center;
              border: 1.5px solid #e2e8f0; border-radius: 10px;
              padding: 10px 36px 10px 14px;
              font-size: 14px; font-family: inherit; color: #1a1a1a; cursor: pointer; outline: none; width: 100%;">
            <option value="ALL">All Departments</option>
            @foreach($departments as $department)
              <option value="{{ $department->code }}" @selected(request('department') === $department->code)>
                {{ $department->code }} — {{ $department->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div style="display: flex; flex-direction: column; gap: 6px; flex: 1; min-width: 170px;">
          <label style="font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #aaa;">Level</label>
          <select name="difficulty"
            style="appearance: none; -webkit-appearance: none;
              background-color: #f8f9fa;
              background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2210%22 height=%226%22 viewBox=%220 0 10 6%22><path d=%22M0 0l5 6 5-6z%22 fill=%22%234285F4%22/></svg>');
              background-repeat: no-repeat; background-position: right 14px center;
              border: 1.5px solid #e2e8f0; border-radius: 10px;
              padding: 10px 36px 10px 14px;
              font-size: 14px; font-family: inherit; color: #1a1a1a; cursor: pointer; outline: none; width: 100%;">
            @foreach($difficulties as $difficulty)
              <option value="{{ $difficulty->value }}" @selected(request('difficulty', 'ALL') === $difficulty->value)>
                {{ $difficulty->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div style="display: flex; align-items: flex-end; gap: 10px;">
          <button type="submit"
            style="background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: #fff; border: none; border-radius: 10px; padding: 11px 24px; font-size: 14px; font-weight: 600; font-family: inherit; cursor: pointer; box-shadow: 0 4px 14px rgba(66,133,244,.3); white-space: nowrap;"
            onmouseover="this.style.opacity='.9'; this.style.transform='translateY(-1px)';"
            onmouseout="this.style.opacity='1'; this.style.transform='';">
            Apply Filters
          </button>

          @if((request('department') && request('department') !== 'ALL') || (request('difficulty') && request('difficulty') !== 'ALL'))
            <a href="{{ route('courses', [], false) }}"
              style="font-size: 13px; color: #aaa; text-decoration: underline; text-underline-offset: 2px; padding-bottom: 12px; white-space: nowrap;">
              Clear
            </a>
          @endif
        </div>

      </form>
    </div>
    @endif

    {{-- ── Count Row ── --}}
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 24px;">
      <span style="font-size: 20px; font-weight: 800; color: #1a1a1a;">{{ $courses->count() }}</span>
      <span style="font-size: 14px; color: #aaa;">course{{ $courses->count() !== 1 ? 's' : '' }} found</span>
      <div style="flex: 1; height: 1px; background: #eaeaea; margin-left: 4px;"></div>
    </div>

    {{-- ── Course Grid ── --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(310px, 1fr)); gap: 18px;">

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

        <div style="background: #fff; border: 1px solid #eaeaea; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 2px 8px rgba(0,0,0,.04); transition: all .2s ease;"
          onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 14px 36px rgba(66,133,244,.14)'; this.style.borderColor='rgba(66,133,244,.4)';"
          onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,.04)'; this.style.borderColor='#eaeaea';">

          {{-- Top gradient stripe --}}
          <div style="height: 4px; background: linear-gradient(90deg, #4285F4 0%, #34A853 100%);"></div>

          <div style="padding: 22px; display: flex; flex-direction: column; gap: 14px; flex: 1;">

            {{-- Top row: icon + badge + duration --}}
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
              <div style="width: 46px; height: 46px; border-radius: 12px; background: linear-gradient(135deg, rgba(66,133,244,.1), rgba(52,168,83,.1)); border: 1px solid rgba(66,133,244,.15); display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                {{ $icon }}
              </div>
              <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 5px;">
                <span style="display: inline-flex; align-items: center; gap: 5px; background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; border: 1px solid {{ $badge['border'] }}; font-size: 10px; font-weight: 700; letter-spacing: .08em; padding: 4px 10px; border-radius: 999px; text-transform: uppercase; white-space: nowrap;">
                  <span style="width: 5px; height: 5px; border-radius: 50%; background: {{ $badge['dot'] }}; flex-shrink: 0;"></span>
                  {{ ucfirst($level) }}
                </span>
                <span style="font-size: 11px; color: #bbb;">🕐 {{ $course->duration ?? 'Self-paced' }}</span>
              </div>
            </div>

            {{-- Title --}}
            <h3 style="font-size: 16px; font-weight: 700; color: #1a1a1a; margin: 0; line-height: 1.35;">
              {{ $course->title }}
            </h3>

            {{-- Description --}}
            <p style="font-size: 13.5px; color: #666; line-height: 1.65; margin: 0; flex: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
              {{ $course->description }}
            </p>

            {{-- Card Footer --}}
            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 14px; border-top: 1px solid #f0f0f0; margin-top: auto;">
              <div style="display: flex; align-items: center; gap: 6px;">
                <span style="width: 7px; height: 7px; border-radius: 50%; background: linear-gradient(135deg, #4285F4, #34A853); flex-shrink: 0;"></span>
                <span style="font-size: 11px; font-weight: 700; color: #555; letter-spacing: .1em; text-transform: uppercase;">
                  {{ $course->department->code ?? 'N/A' }}
                </span>
              </div>
              <a href="{{ route('courses.show', $course->id) }}"
                style="display: inline-flex; align-items: center; gap: 5px; font-size: 13px; font-weight: 600; color: #4285F4; text-decoration: none; padding: 6px 14px; border-radius: 8px; background: rgba(66,133,244,.08); transition: background .15s;"
                onmouseover="this.style.background='rgba(66,133,244,.16)';"
                onmouseout="this.style.background='rgba(66,133,244,.08)';">
                View Details <span style="font-size: 14px;">→</span>
              </a>
            </div>

          </div>
        </div>

      @empty
        <div style="grid-column: 1 / -1; background: #fff; border: 1px dashed #ddd; border-radius: 16px; padding: 64px 20px; text-align: center;">
          <div style="font-size: 52px; margin-bottom: 14px;">🔍</div>
          <h3 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin: 0 0 8px;">No courses found</h3>
          <p style="font-size: 14px; color: #888; margin: 0 0 24px; max-width: 280px; margin-left: auto; margin-right: auto;">
            Try adjusting your department or difficulty filters to find what you're looking for.
          </p>
          <a href="{{ route('courses', [], false) }}"
            style="display: inline-block; padding: 11px 24px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: #fff; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 14px rgba(66,133,244,.3);">
            Clear All Filters
          </a>
        </div>
      @endforelse

    </div>
  </div>
</div>

@endsection