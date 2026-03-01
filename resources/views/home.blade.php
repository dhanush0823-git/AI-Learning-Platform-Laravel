{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'AI Learning Platform - Home')

@section('content')
<div class="homepage">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">Smart Education System for Engineering Colleges</h1>
                <p class="hero-description">
                    AI-powered personalized learning paths, department-specific courses, 
                    and real-time progress tracking for engineering students.
                </p>
                <div class="hero-actions">
                    @auth('student')
                        <a href="{{ route('dashboard') }}" class="primary-btn">Continue Learning →</a>
                    @else
                        <a href="{{ route('register') }}" class="primary-btn">Get Started Free</a>
                        <a href="#foundation-courses" class="secondary-btn">Explore Courses</a>
                    @endauth
                </div>
            </div>
            <div class="hero-stats">
                <div class="stat-card">
                    <h3>5+</h3>
                    <p>Engineering Departments</p>
                </div>
                <div class="stat-card">
                    <h3>25+</h3>
                    <p>Structured Courses</p>
                </div>
                <div class="stat-card">
                    <h3>1000+</h3>
                    <p>Interactive Lessons</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Departments Section -->
    <section class="departments-section">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Choose Your Department</h2>
                <p class="section-subtitle">
                    Access department-specific courses tailored to your engineering field
                </p>
            </div>
            
            <div class="departments-grid">
                @foreach($displayDepartments as $dept)
                <div class="department-card" style="border-top: 4px solid {{ $dept->color }}">
                    <div class="department-icon" style="color: {{ $dept->color }}">
                        {{ $dept->icon }}
                    </div>
                    <div class="department-info">
                        <h3>{{ $dept->code }}</h3>
                        <p>{{ $dept->name }}</p>
                    </div>
                    <div class="course-count">{{ $dept->courses_count ?? 5 }}+ Courses</div>
                </div>
                @endforeach
            </div>
            
            <div class="filter-all-container">
                <a href="{{ route('courses') }}" class="all-departments-btn">
                    All Departments
                </a>
            </div>
        </div>
    </section>

    <!-- Foundation Courses -->
    <section class="foundation-section" id="foundation-courses">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Foundation Courses</h2>
                <p class="section-subtitle">
                    Start your learning journey with these essential beginner courses
                </p>
            </div>
            
            <div class="foundation-courses-grid">
                @foreach($foundationCourses as $course)
                <div class="foundation-course-card">
                    <div class="foundation-course-header">
                        <div class="course-icon">{{ $course->icon ?? '📚' }}</div>
                        <div class="course-header-info">
                            <span class="course-dept">{{ $course->department->code }}</span>
                            <span class="course-duration">{{ $course->duration ?? '4 weeks' }}</span>
                        </div>
                    </div>
                    <h3 class="foundation-course-title">{{ $course->title }}</h3>
                    <p class="foundation-course-description">{{ $course->description }}</p>
                    
                    @if($course->youtube_link)
                    <div class="youtube-link-section">
                        <a href="{{ $course->youtube_link }}" target="_blank" rel="noopener noreferrer" class="youtube-btn">
                            <span class="youtube-icon">▶️</span>
                            Watch YouTube Tutorial
                        </a>
                    </div>
                    @endif
                    
                    <div class="foundation-course-actions">
                        <a href="{{ route('courses.show', $course->id) }}" class="foundation-view-btn">
                            Start Learning →
                        </a>
                        <button class="foundation-demo-btn" onclick="previewCourse({{ $course->id }})">
                            Preview Course
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- AI Features -->
    <section class="ai-features-section">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">AI-Powered Learning Features</h2>
                <p class="section-subtitle">
                    Experience next-generation education with our intelligent platform
                </p>
            </div>
            
            <div class="ai-features-grid">
                @foreach($aiFeatures as $feature)
                <div class="ai-feature-card">
                    <div class="ai-feature-icon">
                        {{ $feature->icon }}
                    </div>
                    <h3 class="ai-feature-title">{{ $feature->title }}</h3>
                    <p class="ai-feature-description">{{ $feature->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="courses-section">
        <div class="section-container">
            <div class="courses-header">
                <div class="header-left">
                    <h1>Browse All Courses</h1>
                    <p>Choose from 25+ courses across 5 engineering departments</p>
                </div>
                
                <div class="difficulty-filter">
                    <label>Filter by Level:</label>
                    <div class="difficulty-buttons">
                        <a href="{{ route('home', ['difficulty' => 'ALL']) }}" 
                           class="difficulty-btn {{ !request('difficulty') || request('difficulty') == 'ALL' ? 'active' : '' }}">
                            All Levels
                        </a>
                        <a href="{{ route('home', ['difficulty' => 'beginner']) }}" 
                           class="difficulty-btn {{ request('difficulty') == 'beginner' ? 'active' : '' }}"
                           style="background: {{ request('difficulty') == 'beginner' ? '#34A853' : '#f8f9fa' }}; color: {{ request('difficulty') == 'beginner' ? 'white' : '#666' }}">
                            Beginner
                        </a>
                        <a href="{{ route('home', ['difficulty' => 'intermediate']) }}" 
                           class="difficulty-btn {{ request('difficulty') == 'intermediate' ? 'active' : '' }}"
                           style="background: {{ request('difficulty') == 'intermediate' ? '#FBBC05' : '#f8f9fa' }}; color: {{ request('difficulty') == 'intermediate' ? 'white' : '#666' }}">
                            Intermediate
                        </a>
                        <a href="{{ route('home', ['difficulty' => 'advanced']) }}" 
                           class="difficulty-btn {{ request('difficulty') == 'advanced' ? 'active' : '' }}"
                           style="background: {{ request('difficulty') == 'advanced' ? '#EA4335' : '#f8f9fa' }}; color: {{ request('difficulty') == 'advanced' ? 'white' : '#666' }}">
                            Advanced
                        </a>
                    </div>
                </div>
            </div>

            <div class="courses-info">
                <p>
                    Showing {{ $courses->count() }} courses 
                    @if(request('department') && request('department') != 'ALL')
                        in {{ $departments->where('code', request('department'))->first()->name ?? request('department') }}
                    @endif
                    @if(request('difficulty') && request('difficulty') != 'ALL')
                        at {{ request('difficulty') }} level
                    @endif
                </p>
            </div>

            <div class="courses-grid">
                @forelse($courses as $course)
                <div class="course-card">
                    <div class="course-header">
                        <div class="course-badges">
                            <span class="difficulty-badge" style="background: 
                                {{ $course->difficulty == 'beginner' ? '#34A853' : 
                                   ($course->difficulty == 'intermediate' ? '#FBBC05' : '#EA4335') }}">
                                {{ strtoupper($course->difficulty) }}
                            </span>
                            <span class="department-badge" style="background: {{ $course->department->color ?? '#f0f0f0' }}20; color: {{ $course->department->color ?? '#666' }}">
                                {{ $course->department->code }}
                            </span>
                        </div>
                        <span class="modules-count">📚 {{ $course->total_modules }} Modules</span>
                    </div>
                    
                    <h3 class="course-title">{{ $course->title }}</h3>
                    <p class="course-description">{{ $course->description }}</p>
                    
                    <div class="course-footer">
                        <span class="course-duration">⏱️ Self-paced</span>
                        <a href="{{ route('courses.show', $course->id) }}" class="enroll-btn">
                            View Details →
                        </a>
                    </div>
                </div>
                @empty
                <div class="no-courses">
                    <p>No courses found for the selected filters.</p>
                    <a href="{{ route('home') }}" class="reset-btn">Reset Filters</a>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    /* Copy all the CSS from your Next.js homepage and paste here */
    .homepage { min-height: 100vh; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); }
    .hero-section { background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%); padding: 80px 20px; border-bottom: 1px solid #eaeaea; }
    .hero-container { max-width: 1200px; margin: 0 auto; }
    .hero-content { text-align: center; margin-bottom: 64px; }
    .hero-title { font-size: 3rem; font-weight: 800; color: #1a1a1a; margin-bottom: 24px; line-height: 1.2; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .hero-description { font-size: 1.2rem; color: #666; max-width: 800px; margin: 0 auto 40px; line-height: 1.6; }
    .hero-actions { display: flex; gap: 20px; justify-content: center; }
    .primary-btn { padding: 16px 36px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; border-radius: 12px; font-weight: 700; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 6px 20px rgba(66, 133, 244, 0.25); text-decoration: none; display: inline-block; }
    .primary-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(66, 133, 244, 0.35); }
    .secondary-btn { padding: 16px 36px; border: 2px solid #4285F4; color: #4285F4; border-radius: 12px; font-weight: 700; font-size: 1.1rem; transition: all 0.3s; background: white; text-decoration: none; display: inline-block; }
    .secondary-btn:hover { background: #4285F4; color: white; transform: translateY(-3px); }
    .hero-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 32px; max-width: 800px; margin: 0 auto; }
    .stat-card { text-align: center; padding: 28px; background: white; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); transition: transform 0.3s; border: 1px solid #eaeaea; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(0,0,0,0.12); }
    .stat-card h3 { font-size: 2.8rem; color: #4285F4; margin-bottom: 12px; font-weight: 800; }
    .stat-card p { color: #666; font-size: 1rem; font-weight: 600; }
    .section-container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
    .section-header { text-align: center; margin-bottom: 64px; }
    .section-title { font-size: 2.8rem; font-weight: 800; color: #1a1a1a; margin-bottom: 16px; }
    .section-subtitle { text-align: center; color: #666; font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6; }
    .departments-section { padding: 80px 0; background: white; }
    .departments-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .department-card { background: white; border: 1px solid #eaeaea; border-radius: 12px; padding: 25px; text-align: center; transition: all 0.3s ease; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.05); height: 220px; display: flex; flex-direction: column; justify-content: center; align-items: center; }
    .department-card:hover { transform: translateY(-5px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
    .department-card.active { border-color: #4285F4; box-shadow: 0 5px 20px rgba(66, 133, 244, 0.15); }
    .department-icon { font-size: 2.5rem; margin-bottom: 15px; transition: transform 0.3s; }
    .department-card:hover .department-icon { transform: scale(1.05); }
    .department-info h3 { font-size: 1.5rem; margin-bottom: 8px; color: #1a1a1a; font-weight: 700; }
    .department-info p { color: #666; font-size: 0.9rem; margin-bottom: 15px; line-height: 1.4; }
    .course-count { display: inline-block; background: rgba(66, 133, 244, 0.1); color: #4285F4; padding: 6px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; border: 1px solid rgba(66, 133, 244, 0.2); }
    .filter-all-container { text-align: center; }
    .all-departments-btn { padding: 12px 28px; background: #f8f9fa; color: #666; border-radius: 10px; font-weight: 600; font-size: 1rem; transition: all 0.3s; border: 2px solid #eaeaea; text-decoration: none; display: inline-block; }
    .all-departments-btn:hover { background: #eaeaea; transform: translateY(-2px); }
    .foundation-section { padding: 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); }
    .foundation-courses-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; }
    .foundation-course-card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s; border: 1px solid #eaeaea; min-height: 400px; display: flex; flex-direction: column; position: relative; }
    .foundation-course-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #4285F4, #34A853); }
    .foundation-course-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
    .foundation-course-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
    .course-icon { font-size: 2.5rem; background: rgba(66, 133, 244, 0.1); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
    .course-header-info { flex: 1; display: flex; justify-content: space-between; align-items: center; }
    .course-dept { background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    .course-duration { color: #666; font-size: 0.85rem; font-weight: 500; }
    .foundation-course-title { font-size: 1.4rem; color: #1a1a1a; margin-bottom: 15px; font-weight: 700; }
    .foundation-course-description { color: #666; margin-bottom: 20px; line-height: 1.6; flex-grow: 1; }
    .youtube-link-section { margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #FF0000; }
    .youtube-btn { display: inline-flex; align-items: center; gap: 10px; padding: 12px 24px; background: #FF0000; color: white; border-radius: 8px; font-weight: 600; transition: all 0.3s; text-decoration: none; }
    .youtube-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 0, 0, 0.3); }
    .foundation-course-actions { display: flex; gap: 12px; margin-top: auto; }
    .foundation-view-btn { flex: 1; padding: 12px 20px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; border-radius: 8px; font-weight: 600; text-align: center; transition: all 0.3s; text-decoration: none; }
    .foundation-view-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(66, 133, 244, 0.3); }
    .foundation-demo-btn { padding: 12px 20px; background: #f8f9fa; color: #666; border-radius: 8px; font-weight: 500; border: 1px solid #eaeaea; transition: all 0.3s; cursor: pointer; }
    .foundation-demo-btn:hover { background: #eaeaea; transform: translateY(-2px); }
    .ai-features-section { padding: 80px 0; background: white; }
    .ai-features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; }
    .ai-feature-card { background: white; border-radius: 12px; padding: 25px; text-align: center; border: 1px solid #eaeaea; transition: all 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.05); min-height: 280px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .ai-feature-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .ai-feature-icon { font-size: 2.5rem; margin-bottom: 20px; }
    .ai-feature-title { font-size: 1.2rem; color: #1a1a1a; margin-bottom: 12px; font-weight: 700; }
    .ai-feature-description { color: #666; font-size: 0.9rem; line-height: 1.5; }
    .courses-section { padding: 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); }
    .courses-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 25px; }
    .header-left h1 { font-size: 2.2rem; color: #1a1a1a; margin-bottom: 10px; font-weight: 800; }
    .header-left p { color: #666; font-size: 1rem; }
    .difficulty-filter { display: flex; flex-direction: column; gap: 12px; }
    .difficulty-filter label { font-weight: 600; color: #4a5568; }
    .difficulty-buttons { display: flex; gap: 10px; flex-wrap: wrap; }
    .difficulty-btn { padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 500; transition: all 0.3s; border: 1px solid #eaeaea; background: white; cursor: pointer; text-decoration: none; display: inline-block; }
    .difficulty-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .difficulty-btn.active { background: #4285F4; color: white; border-color: transparent; }
    .courses-info { margin-bottom: 30px; padding: 20px; background: white; border-radius: 10px; color: #666; border: 1px solid #eaeaea; }
    .courses-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px; }
    .course-card { background: white; border: 1px solid #eaeaea; border-radius: 12px; padding: 25px; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(0,0,0,0.05); display: flex; flex-direction: column; }
    .course-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-color: #4285F4; }
    .course-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
    .course-badges { display: flex; gap: 8px; flex-wrap: wrap; }
    .difficulty-badge { padding: 6px 12px; border-radius: 16px; font-size: 0.75rem; font-weight: 600; color: white; }
    .department-badge { padding: 6px 12px; border-radius: 16px; font-size: 0.75rem; font-weight: 600; }
    .course-title { font-size: 1.3rem; color: #1a1a1a; margin-bottom: 15px; font-weight: 700; }
    .course-description { color: #666; margin-bottom: 20px; line-height: 1.6; flex-grow: 1; }
    .course-footer { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
    .course-duration { display: flex; align-items: center; gap: 8px; color: #666; }
    .enroll-btn { padding: 10px 20px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; border-radius: 8px; font-weight: 600; transition: all 0.3s; text-decoration: none; }
    .enroll-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(66, 133, 244, 0.25); }
    .no-courses { text-align: center; padding: 60px; background: white; border-radius: 12px; }
    .reset-btn { margin-top: 20px; padding: 12px 28px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s; border: none; text-decoration: none; display: inline-block; }
    .reset-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(66, 133, 244, 0.25); }
    
    @media (max-width: 1024px) {
        .hero-title { font-size: 2.5rem; }
        .section-title { font-size: 2.2rem; }
        .departments-grid { grid-template-columns: repeat(3, 1fr); }
    }
    
    @media (max-width: 768px) {
        .hero-title { font-size: 2rem; }
        .hero-actions { flex-direction: column; }
        .departments-grid { grid-template-columns: repeat(2, 1fr); }
        .foundation-courses-grid { grid-template-columns: 1fr; }
        .ai-features-grid { grid-template-columns: 1fr; }
        .courses-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@push('scripts')
<script>
function previewCourse(courseId) {
    alert('Course preview feature coming soon!');
}
</script>
@endpush