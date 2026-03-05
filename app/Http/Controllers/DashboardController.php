<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\LessonProgress;
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
        
        // Get enrolled courses with progress and resume pointers
        $courses = $student->enrolledCourses()->with(['department', 'modules.lessons'])->get()->map(function($course) use ($student) {
            $lessonIds = $course->modules
                ->flatMap(fn ($module) => $module->lessons->pluck('id'))
                ->values();

            $completedLessons = $lessonIds->isEmpty()
                ? 0
                : $student->lessonProgress()
                    ->whereIn('lesson_id', $lessonIds)
                    ->where('status', 'completed')
                    ->count();

            $timeSpentSeconds = $lessonIds->isEmpty()
                ? 0
                : (int) $student->lessonProgress()
                    ->whereIn('lesson_id', $lessonIds)
                    ->sum('time_spent');

            $latestProgress = $lessonIds->isEmpty()
                ? null
                : LessonProgress::with('lesson.module')
                    ->where('student_id', $student->id)
                    ->whereIn('lesson_id', $lessonIds)
                    ->orderByDesc('last_accessed_at')
                    ->orderByDesc('updated_at')
                    ->first();

            $firstLesson = $course->modules
                ->sortBy('module_number')
                ->flatMap(fn ($module) => $module->lessons->sortBy('lesson_number'))
                ->first();

            $targetLesson = $latestProgress?->lesson ?? $firstLesson;
            $continueRoute = $targetLesson
                ? route('learn.lesson', [
                    'courseId' => $course->id,
                    'moduleId' => $targetLesson->module_id,
                    'lessonId' => $targetLesson->id,
                ])
                : route('learn.course', $course->id);

            $computedProgress = $lessonIds->count() > 0
                ? (int) round(($completedLessons / $lessonIds->count()) * 100)
                : (int) ($course->pivot->progress ?? 0);

            return (object)[
                'id' => $course->id,
                'title' => $course->title,
                'department' => $course->department->code,
                'difficulty' => $course->difficulty,
                'progress' => max((int) ($course->pivot->progress ?? 0), $computedProgress),
                'next_lesson' => $targetLesson ? $targetLesson->title : 'No lessons',
                'continue_route' => $continueRoute,
                'time_spent_human' => $this->formatDuration($timeSpentSeconds),
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

    protected function formatDuration(int $seconds): string
    {
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }

        return "{$minutes}m";
    }
}
