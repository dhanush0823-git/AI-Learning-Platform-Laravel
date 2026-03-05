<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Assessments;
use App\Models\LessonProgress;
use App\Models\Enrollments;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        
        // Load relationships
        $student->load('enrolledCourses', 'assessments', 'analytics');

        $enrolledCourses = $student->enrolledCourses()->with(['department', 'modules.lessons'])->get();
        $completedCoursesCount = $enrolledCourses->filter(function ($course) {
            $progress = (int) round((float) ($course->pivot->progress ?? 0));
            return (bool) ($course->pivot->completed ?? false) || $progress >= 100;
        })->count();
        $inProgressCoursesCount = $enrolledCourses->filter(function ($course) {
            $progress = (int) round((float) ($course->pivot->progress ?? 0));
            return ! ((bool) ($course->pivot->completed ?? false) || $progress >= 100);
        })->count();
        $averageProgress = (int) round((float) $enrolledCourses->avg(fn ($course) => (float) ($course->pivot->progress ?? 0)));
        
        // Calculate stats
        $stats = (object)[
            'courses_available' => Course::count(),
            'enrolled_courses' => $enrolledCourses->count(),
            'completed_courses' => $completedCoursesCount,
            'in_progress_courses' => $inProgressCoursesCount,
            'total_progress' => $averageProgress,
            'streak_days' => $student->streak_days
        ];
        
        // Build course cards with resume pointers
        $courseCards = $enrolledCourses->map(function($course) use ($student) {
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

            $finalProgress = max((int) ($course->pivot->progress ?? 0), $computedProgress);
            $isCompleted = (bool) ($course->pivot->completed ?? false) || $finalProgress >= 100;

            return (object)[
                'id' => $course->id,
                'title' => $course->title,
                'department' => $course->department->code,
                'difficulty' => $course->difficulty,
                'progress' => $finalProgress,
                'next_lesson' => $isCompleted ? 'Course completed' : ($targetLesson ? $targetLesson->title : 'No lessons'),
                'continue_route' => $continueRoute,
                'review_route' => route('courses.show', $course->id),
                'time_spent_human' => $this->formatDuration($timeSpentSeconds),
                'is_completed' => $isCompleted,
            ];
        });

        $inProgressCourses = $courseCards
            ->filter(fn ($course) => ! $course->is_completed)
            ->values();

        $completedCourses = $courseCards
            ->filter(fn ($course) => $course->is_completed)
            ->values();
        
        // Recent activity (dynamic)
        $lessonActivities = LessonProgress::query()
            ->with('lesson.module.course')
            ->where('student_id', $student->id)
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->limit(10)
            ->get()
            ->map(function ($progress) {
                $courseTitle = $progress->lesson?->module?->course?->title ?? 'Course';

                return (object) [
                    'id' => 'lesson-' . $progress->id,
                    'course' => $courseTitle,
                    'action' => 'Completed lesson',
                    'time' => optional($progress->completed_at)->diffForHumans() ?? 'Just now',
                    'icon' => '✅',
                    'timestamp' => optional($progress->completed_at)->timestamp ?? 0,
                ];
            });

        $assessmentActivities = Assessments::query()
            ->with('module.course')
            ->where('student_id', $student->id)
            ->latest('completed_at')
            ->latest('created_at')
            ->limit(10)
            ->get()
            ->map(function ($assessment) {
                $eventTime = $assessment->completed_at ?? $assessment->created_at;
                $courseTitle = $assessment->module?->course?->title ?? 'Assessment';

                return (object) [
                    'id' => 'assessment-' . $assessment->id,
                    'course' => $courseTitle,
                    'action' => 'Took assessment',
                    'time' => optional($eventTime)->diffForHumans() ?? 'Just now',
                    'icon' => '📝',
                    'timestamp' => optional($eventTime)->timestamp ?? 0,
                ];
            });

        $enrollmentActivities = Enrollments::query()
            ->with('course')
            ->where('student_id', $student->id)
            ->latest('enrolled_at')
            ->limit(10)
            ->get()
            ->map(function ($enrollment) {
                $eventTime = $enrollment->enrolled_at ?? $enrollment->created_at;

                return (object) [
                    'id' => 'enrollment-' . $enrollment->id,
                    'course' => $enrollment->course?->title ?? 'Course',
                    'action' => 'Enrolled in course',
                    'time' => optional($eventTime)->diffForHumans() ?? 'Just now',
                    'icon' => '🚀',
                    'timestamp' => optional($eventTime)->timestamp ?? 0,
                ];
            });

        $courseCompletedActivities = Enrollments::query()
            ->with('course')
            ->where('student_id', $student->id)
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->limit(10)
            ->get()
            ->map(function ($enrollment) {
                $eventTime = $enrollment->completed_at;

                return (object) [
                    'id' => 'course-completed-' . $enrollment->id,
                    'course' => $enrollment->course?->title ?? 'Course',
                    'action' => 'Completed course',
                    'time' => optional($eventTime)->diffForHumans() ?? 'Just now',
                    'icon' => '🏁',
                    'timestamp' => optional($eventTime)->timestamp ?? 0,
                ];
            });

        $recentActivity = $lessonActivities
            ->concat($assessmentActivities)
            ->concat($enrollmentActivities)
            ->concat($courseCompletedActivities)
            ->sortByDesc('timestamp')
            ->take(5)
            ->values();

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
            'in_progress_courses' => $inProgressCourses,
            'completed_courses' => $completedCourses,
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
