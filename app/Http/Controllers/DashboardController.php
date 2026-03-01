<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        
        // Load relationships
        $student->load('enrolledCourses', 'assessments', 'analytics');
        
        // Calculate stats
        $stats = (object)[
            'courses_available' => Course::count(),
            'enrolled_courses' => $student->enrolledCourses->count(),
            'lessons_completed' => $student->lessonProgress()->where('status', 'completed')->count(),
            'total_progress' => $student->total_progress,
            'streak_days' => $student->streak_days
        ];
        
        // Get enrolled courses with progress
        $courses = $student->enrolledCourses()->with('department')->get()->map(function($course) {
            return (object)[
                'id' => $course->id,
                'title' => $course->title,
                'department' => $course->department->code,
                'difficulty' => $course->difficulty,
                'progress' => $course->pivot->progress,
                'next_lesson' => 'Continue Learning' // You can calculate this
            ];
        });
        
        // Recent activity
        $recentActivity = collect([
            (object)['id' => 1, 'course' => 'Python Programming', 'action' => 'Completed lesson', 'time' => '2 hours ago', 'icon' => '✅'],
            (object)['id' => 2, 'course' => 'Machine Learning', 'action' => 'Took assessment', 'time' => 'Yesterday', 'icon' => '📝'],
            (object)['id' => 3, 'course' => 'Digital Electronics', 'action' => 'Started new module', 'time' => '2 days ago', 'icon' => '🚀']
        ]);
        
        // Recommendations
        $recommendations = Course::where('difficulty', $student->level)
            ->whereNotIn('id', $student->enrolledCourses->pluck('id'))
            ->limit(2)
            ->get()
            ->map(function($course) {
                return (object)[
                    'id' => $course->id,
                    'title' => $course->title,
                    'reason' => 'Based on your learning level',
                    'level' => ucfirst($course->difficulty)
                ];
            });
        
        // Heatmap data
        $heatmap = collect([
            (object)['skill' => 'Arrays', 'score' => 85, 'color' => '#34A853'],
            (object)['skill' => 'Linked Lists', 'score' => 70, 'color' => '#FBBC05'],
            (object)['skill' => 'Trees', 'score' => 45, 'color' => '#EA4335'],
            (object)['skill' => 'Graphs', 'score' => 30, 'color' => '#EA4335'],
            (object)['skill' => 'Sorting', 'score' => 60, 'color' => '#FBBC05'],
            (object)['skill' => 'DP', 'score' => 25, 'color' => '#EA4335']
        ]);
        
        $dashboardData = (object)[
            'stats' => $stats,
            'courses' => $courses,
            'recent_activity' => $recentActivity,
            'recommendations' => $recommendations,
            'heatmap' => $heatmap,
            'riskLevel' => 'Low',
            'studyRecommendation' => (object)[
                'bestTime' => '7-9 PM',
                'duration' => '45 min',
                'focus' => 'Tree Algorithms'
            ]
        ];
        
        return view('dashboard', compact('student', 'dashboardData'));
    }
}
