{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - AI Learning Platform')

@section('content')
<div class="dashboard-page">
    <div class="dashboard-container">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-content">
                <div class="welcome-section">
                    <h1>Welcome back, {{ $student->name }}! 👋</h1>
                    <p class="welcome-subtitle">
                        Here's your learning overview for today
                    </p>
                </div>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-label">Current Level</span>
                        <span class="stat-value">{{ strtoupper($student->level) }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Department</span>
                        <span class="stat-value">{{ $student->department->name ?? 'Not Assigned' }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Student ID</span>
                        <span class="stat-value">{{ $student->reg_no }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card" style="background: linear-gradient(135deg, #4285F4 0%, #34A853 100%)">
                <div class="stat-icon">📚</div>
                <div class="stat-content">
                    <h3>Courses Available</h3>
                    <p class="stat-number">{{ $dashboardData->stats->courses_available }}</p>
                </div>
            </div>
            
            <div class="stat-card" style="background: linear-gradient(135deg, #FF9800 0%, #FF5722 100%)">
                <div class="stat-icon">🎯</div>
                <div class="stat-content">
                    <h3>Lessons Completed</h3>
                    <p class="stat-number">{{ $dashboardData->stats->lessons_completed }}</p>
                </div>
            </div>
            
            <div class="stat-card" style="background: linear-gradient(135deg, #9C27B0 0%, #673AB7 100%)">
                <div class="stat-icon">📈</div>
                <div class="stat-content">
                    <h3>Total Progress</h3>
                    <p class="stat-number">{{ $dashboardData->stats->total_progress }}%</p>
                </div>
            </div>
            
            <div class="stat-card" style="background: linear-gradient(135deg, #00BCD4 0%, #0097A7 100%)">
                <div class="stat-icon">🔥</div>
                <div class="stat-content">
                    <h3>Learning Streak</h3>
                    <p class="stat-number">{{ $dashboardData->stats->streak_days }} days</p>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs-container" x-data="{ activeTab: 'overview' }">
            <div class="tabs">
                <button class="tab" :class="{ 'active': activeTab === 'overview' }" @click="activeTab = 'overview'">Overview</button>
                <button class="tab" :class="{ 'active': activeTab === 'heatmap' }" @click="activeTab = 'heatmap'">Skill Heatmap</button>
                <button class="tab" :class="{ 'active': activeTab === 'analytics' }" @click="activeTab = 'analytics'">Analytics</button>
            </div>

            <!-- Overview Tab -->
            <div x-show="activeTab === 'overview'" class="dashboard-content">
                <div class="content-left">
                    <!-- Enrolled Courses -->
                    <div class="content-card">
                        <div class="card-header">
                            <h2>📚 Your Courses</h2>
                            <a href="{{ route('courses') }}" class="view-all-btn">
                                View All Courses →
                            </a>
                        </div>
                        
                        @if($dashboardData->courses->isNotEmpty())
                            <div class="courses-list">
                                @foreach($dashboardData->courses as $course)
                                <div class="course-item">
                                    <div class="course-info">
                                        <h3>{{ $course->title }}</h3>
                                        <div class="course-meta">
                                            <span class="department-badge">{{ $course->department }}</span>
                                            <span class="difficulty-badge {{ $course->difficulty }}">
                                                {{ $course->difficulty }}
                                            </span>
                                        </div>
                                        <p class="next-lesson">Next: {{ $course->next_lesson }}</p>
                                        <p class="next-lesson">Time spent: {{ $course->time_spent_human }}</p>
                                    </div>
                                    <div class="course-progress">
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $course->progress }}%"></div>
                                        </div>
                                        <span class="progress-text">{{ $course->progress }}% complete</span>
                                        <a href="{{ $course->continue_route }}" class="continue-btn">
                                            Continue →
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <p>No courses enrolled yet.</p>
                                <a href="{{ route('courses') }}" class="browse-btn">
                                    Browse Courses
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Recent Activity -->
                    <div class="content-card">
                        <h2>📋 Recent Activity</h2>
                        <div class="activity-list">
                            @foreach($dashboardData->recent_activity as $activity)
                            <div class="activity-item">
                                <div class="activity-icon">{{ $activity->icon }}</div>
                                <div class="activity-details">
                                    <p class="activity-text">
                                        {{ $activity->action }} in <strong>{{ $activity->course }}</strong>
                                    </p>
                                    <span class="activity-time">{{ $activity->time }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="content-right">
                    <!-- Quick Actions -->
                    <div class="content-card">
                        <h2>🚀 Quick Actions</h2>
                        <div class="quick-actions">
                            <a href="{{ route('courses') }}" class="action-btn">
                                <span class="action-icon">🔍</span>
                                <span>Browse Courses</span>
                            </a>
                            
                            <a href="{{ route('learn') }}" class="action-btn">
                                <span class="action-icon">▶️</span>
                                <span>Continue Learning</span>
                            </a>
                            
                            <a href="{{ route('assessments') }}" class="action-btn">
                                <span class="action-icon">📝</span>
                                <span>Take Assessment</span>
                            </a>
                            
                            <a href="{{ route('progress') }}" class="action-btn">
                                <span class="action-icon">📊</span>
                                <span>View Progress Report</span>
                            </a>
                        </div>
                    </div>

                    <!-- AI Recommendations -->
                    <div class="content-card ai-recommendations">
                        <h2>🤖 AI Recommendations</h2>
                        <div class="recommendations-list">
                            @foreach($dashboardData->recommendations as $rec)
                            <div class="recommendation-item">
                                <div class="rec-icon">⭐</div>
                                <div class="rec-details">
                                    <h4>{{ $rec->title }}</h4>
                                    <p>{{ $rec->reason }}</p>
                                    <span class="rec-level">{{ $rec->level }}</span>
                                </div>
                                <a href="{{ route('courses.show', $rec->id) }}" class="explore-rec">
                                    Explore
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="ai-tips">
                            <p>💡 <strong>AI Tip:</strong> Study for 30 minutes daily to maintain your learning streak!</p>
                        </div>
                    </div>

                    <!-- Early Warning System -->
                    <div class="content-card warning-card">
                        <h2>⚠️ Early Warning System</h2>
                        <div class="warning-content">
                            <div class="risk-indicator">
                                <div class="risk-level" style="background: {{ $dashboardData->riskLevel == 'Low' ? '#34A853' : ($dashboardData->riskLevel == 'Medium' ? '#FBBC05' : '#EA4335') }}">
                                    {{ $dashboardData->riskLevel }} Risk
                                </div>
                                <p>Based on your recent engagement patterns</p>
                            </div>
                            <div class="warning-message">
                                @if($dashboardData->riskLevel == 'Low')
                                    You're on track! Keep up the good work.
                                @elseif($dashboardData->riskLevel == 'Medium')
                                    Consider increasing your study time to maintain momentum.
                                @else
                                    Your engagement has dropped. Let's get you back on track!
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Heatmap Tab -->
            <div x-show="activeTab === 'heatmap'" x-cloak class="content-card heatmap-section">
                <h2>📊 Department-Wise Skill Heatmap</h2>
                <p class="card-subtitle">Your strengths and areas for improvement across different topics</p>
                
                <div class="heatmap-grid">
                    @foreach($dashboardData->heatmap as $skill)
                    <div class="heatmap-item">
                        <div class="heatmap-skill">{{ $skill->skill }}</div>
                        <div class="heatmap-score" style="color: {{ $skill->color }}">{{ $skill->score }}%</div>
                        <div class="heatmap-label">
                            @if($skill->score >= 80) Strong
                            @elseif($skill->score >= 50) Average
                            @else Needs Work
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Study Recommendation Card -->
                <div class="study-rec-card">
                    <div class="study-rec-title">📝 Personalized Study Recommendation</div>
                    <div class="study-rec-detail">
                        <span class="rec-label">Best Study Time:</span>
                        <span class="rec-value">{{ $dashboardData->studyRecommendation->bestTime }}</span>
                    </div>
                    <div class="study-rec-detail">
                        <span class="rec-label">Recommended Duration:</span>
                        <span class="rec-value">{{ $dashboardData->studyRecommendation->duration }}</span>
                    </div>
                    <div class="study-rec-detail">
                        <span class="rec-label">Focus Area:</span>
                        <span class="rec-value">{{ $dashboardData->studyRecommendation->focus }}</span>
                    </div>
                </div>
            </div>

            <!-- Analytics Tab -->
            <div x-show="activeTab === 'analytics'" x-cloak class="content-card">
                <h2>📈 Learning Analytics</h2>
                <p>Advanced analytics coming soon...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard-page { min-height: 100vh; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); padding: 30px 0 60px; }
    .dashboard-container { max-width: 1400px; margin: 0 auto; padding: 0 24px; }
    .dashboard-header { background: white; border-radius: 20px; padding: 40px; margin-bottom: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
    .header-content { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 30px; }
    .welcome-section h1 { font-size: 2.5rem; color: #1a1a1a; margin-bottom: 10px; font-weight: 800; }
    .welcome-subtitle { color: #666; font-size: 1.1rem; }
    .header-stats { display: flex; gap: 30px; flex-wrap: wrap; }
    .stat-item { display: flex; flex-direction: column; align-items: center; padding: 15px 25px; background: rgba(66, 133, 244, 0.05); border-radius: 15px; border: 1px solid rgba(66, 133, 244, 0.1); }
    .stat-label { font-size: 0.85rem; color: #666; margin-bottom: 5px; font-weight: 500; }
    .stat-value { font-size: 1.1rem; font-weight: 700; color: #4285F4; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-bottom: 40px; }
    .stat-card { border-radius: 20px; padding: 30px; color: white; display: flex; align-items: center; gap: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transition: transform 0.3s; }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-icon { font-size: 2.5rem; background: rgba(255,255,255,0.2); width: 70px; height: 70px; border-radius: 15px; display: flex; align-items: center; justify-content: center; }
    .stat-content h3 { font-size: 1rem; font-weight: 600; margin-bottom: 5px; opacity: 0.9; }
    .stat-number { font-size: 2.2rem; font-weight: 800; margin: 0; }
    .tabs-container { margin-bottom: 30px; }
    .tabs { display: flex; gap: 10px; border-bottom: 1px solid #eaeaea; padding-bottom: 10px; }
    .tab { padding: 10px 20px; color: #666; font-weight: 600; cursor: pointer; transition: all 0.3s; border-radius: 8px; background: none; border: none; }
    .tab:hover { color: #4285F4; background: rgba(66, 133, 244, 0.05); }
    .tab.active { color: #4285F4; background: rgba(66, 133, 244, 0.1); }
    [x-cloak] { display: none !important; }
    .dashboard-content { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
    .content-card { background: white; border-radius: 20px; padding: 30px; margin-bottom: 30px; box-shadow: 0 8px 30px rgba(0,0,0,0.06); }
    .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .content-card h2 { font-size: 1.5rem; color: #1a1a1a; margin: 0; font-weight: 700; }
    .view-all-btn { color: #4285F4; font-weight: 600; font-size: 0.95rem; transition: all 0.3s; text-decoration: none; }
    .view-all-btn:hover { transform: translateX(5px); }
    .courses-list { display: flex; flex-direction: column; gap: 20px; }
    .course-item { padding: 25px; border: 2px solid #f0f0f0; border-radius: 15px; transition: all 0.3s; }
    .course-item:hover { border-color: #4285F4; transform: translateY(-3px); box-shadow: 0 10px 25px rgba(66, 133, 244, 0.1); }
    .course-info h3 { font-size: 1.2rem; margin-bottom: 10px; color: #1a1a1a; }
    .course-meta { display: flex; gap: 10px; margin-bottom: 15px; }
    .department-badge { background: rgba(66, 133, 244, 0.1); color: #4285F4; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
    .difficulty-badge { padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; text-transform: capitalize; }
    .difficulty-badge.beginner { background: rgba(52, 168, 83, 0.1); color: #34A853; }
    .difficulty-badge.intermediate { background: rgba(255, 152, 0, 0.1); color: #FF9800; }
    .difficulty-badge.advanced { background: rgba(234, 67, 53, 0.1); color: #EA4335; }
    .next-lesson { color: #666; font-size: 0.95rem; margin: 0; }
    .course-progress { margin-top: 20px; }
    .progress-bar { height: 8px; background: #f0f0f0; border-radius: 4px; overflow: hidden; margin-bottom: 10px; }
    .progress-fill { height: 100%; background: linear-gradient(90deg, #4285F4, #34A853); border-radius: 4px; transition: width 0.3s ease; }
    .progress-text { display: block; color: #666; font-size: 0.9rem; margin-bottom: 15px; }
    .continue-btn { display: inline-block; padding: 10px 20px; background: #4285F4; color: white; border-radius: 10px; font-weight: 600; font-size: 0.95rem; transition: all 0.3s; text-decoration: none; }
    .continue-btn:hover { background: #3367D6; transform: translateY(-2px); }
    .empty-state { text-align: center; padding: 40px; }
    .empty-state p { color: #666; margin-bottom: 20px; }
    .browse-btn { display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; border-radius: 10px; font-weight: 600; box-shadow: 0 8px 20px rgba(66, 133, 244, 0.3); text-decoration: none; }
    .activity-list { display: flex; flex-direction: column; gap: 20px; }
    .activity-item { display: flex; align-items: center; gap: 15px; padding: 15px; border-radius: 10px; background: #f8f9fa; }
    .activity-icon { font-size: 1.2rem; }
    .activity-details { flex: 1; }
    .activity-text { margin: 0 0 5px 0; color: #333; }
    .activity-time { font-size: 0.85rem; color: #666; }
    .quick-actions { display: flex; flex-direction: column; gap: 15px; }
    .action-btn { display: flex; align-items: center; gap: 15px; padding: 18px; background: #f8f9fa; border-radius: 12px; color: #333; font-weight: 600; transition: all 0.3s; text-decoration: none; }
    .action-btn:hover { background: #4285F4; color: white; transform: translateX(5px); }
    .action-icon { font-size: 1.2rem; }
    .ai-recommendations { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: white; }
    .ai-recommendations h2 { color: white; }
    .recommendations-list { margin: 25px 0; }
    .recommendation-item { display: flex; align-items: center; gap: 15px; padding: 20px; background: rgba(255,255,255,0.1); border-radius: 15px; margin-bottom: 15px; }
    .rec-icon { font-size: 1.5rem; }
    .rec-details { flex: 1; }
    .rec-details h4 { margin: 0 0 5px 0; font-size: 1.1rem; color: white; }
    .rec-details p { margin: 0 0 10px 0; color: rgba(255,255,255,0.8); font-size: 0.9rem; }
    .rec-level { display: inline-block; padding: 4px 10px; background: rgba(66, 133, 244, 0.3); border-radius: 12px; font-size: 0.8rem; font-weight: 600; color: white; }
    .explore-rec { padding: 8px 16px; background: rgba(255,255,255,0.2); color: white; border-radius: 8px; font-size: 0.9rem; font-weight: 600; transition: all 0.3s; text-decoration: none; }
    .explore-rec:hover { background: #4285F4; transform: translateY(-2px); }
    .ai-tips { margin-top: 20px; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 10px; font-size: 0.95rem; }
    .heatmap-section { margin-top: 30px; }
    .heatmap-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 15px; margin-top: 20px; }
    .heatmap-item { text-align: center; padding: 15px; border-radius: 10px; background: #f8f9fa; transition: all 0.3s; }
    .heatmap-item:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .heatmap-skill { font-weight: 600; color: #1a1a1a; margin-bottom: 8px; }
    .heatmap-score { font-size: 1.5rem; font-weight: 700; margin-bottom: 5px; }
    .heatmap-label { font-size: 0.85rem; color: #666; }
    .study-rec-card { background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; padding: 25px; border-radius: 16px; margin-top: 25px; }
    .study-rec-title { font-size: 1.2rem; font-weight: 700; margin-bottom: 15px; }
    .study-rec-detail { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.2); }
    .study-rec-detail:last-child { border-bottom: none; }
    .rec-label { opacity: 0.9; }
    .rec-value { font-weight: 600; }
    .warning-card { border-left: 4px solid {{ $dashboardData->riskLevel == 'Low' ? '#34A853' : ($dashboardData->riskLevel == 'Medium' ? '#FBBC05' : '#EA4335') }}; }
    .risk-indicator { display: flex; align-items: center; gap: 20px; margin-bottom: 15px; }
    .risk-level { padding: 8px 16px; border-radius: 20px; color: white; font-weight: 600; font-size: 0.9rem; }
    .warning-message { color: #666; line-height: 1.6; }
    
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .dashboard-content { grid-template-columns: 1fr; }
    }
    
    @media (max-width: 768px) {
        .header-content { flex-direction: column; text-align: center; }
        .header-stats { justify-content: center; }
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush
