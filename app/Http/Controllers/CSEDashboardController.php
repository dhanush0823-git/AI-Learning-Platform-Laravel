<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Departments;
use App\Models\Enrollments;
use App\Models\LessonProgress;
use App\Models\Students;
use App\Models\Assessments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class CSEDashboardController extends Controller
{
    public function cseDashboard()
    {
        $admin = Auth::guard('web')->user();
        $departmentId = $admin?->department_id;

        $department = $departmentId
            ? Departments::find($departmentId)
            : null;

        $students = $departmentId
            ? Students::query()
                ->with('department')
                ->with(['enrolledCourses' => function ($query) {
                    $query->withPivot('progress', 'completed', 'enrolled_at', 'completed_at')
                        ->orderByDesc('enrollments.updated_at');
                }])
                ->withCount('enrollments')
                ->withAvg('enrollments', 'progress')
                ->withMax('enrollments', 'updated_at')
                ->withMax('lessonProgress', 'updated_at')
                ->where('department_id', $departmentId)
                ->latest()
                ->get()
                ->map(function ($student) {
                    $progress = (int) round((float) ($student->enrollments_avg_progress ?? 0));
                    $lastEnrollmentAt = $student->enrollments_max_updated_at ? Carbon::parse($student->enrollments_max_updated_at) : null;
                    $lastLessonAt = $student->lesson_progress_max_updated_at ? Carbon::parse($student->lesson_progress_max_updated_at) : null;
                    $lastActiveAt = collect([$lastEnrollmentAt, $lastLessonAt, $student->updated_at])->filter()->max();

                    $student->progress = $progress;
                    $student->status = ($lastActiveAt && $lastActiveAt->gt(now()->subDays(14))) ? 'active' : 'inactive';

                    $completedCourses = $student->enrolledCourses->filter(function ($course) {
                        $courseProgress = (int) round((float) ($course->pivot->progress ?? 0));
                        return (bool) ($course->pivot->completed ?? false) || $courseProgress >= 100;
                    });

                    $recentCourses = $student->enrolledCourses
                        ->take(3)
                        ->values()
                        ->map(function ($course, $index) {
                            $icons = ['💻', '🤖', '📊'];

                            return [
                                'icon' => $icons[$index % count($icons)],
                                'title' => $course->title,
                                'progress' => (int) round((float) ($course->pivot->progress ?? 0)),
                            ];
                        })
                        ->all();

                    $student->modal_data = [
                        'name' => $student->name,
                        'email' => $student->email,
                        'dept' => $student->department->code ?? 'N/A',
                        'progress' => $student->progress,
                        'status' => $student->status,
                        'courses' => (int) ($student->enrollments_count ?? 0),
                        'completed' => $completedCourses->count(),
                        'certificates' => $completedCourses->count(),
                        'recent_courses' => $recentCourses,
                    ];

                    return $student;
                })
            : collect();

        $totalStudents = $students->count();
        $totalCourses = $departmentId
            ? Course::where('department_id', $departmentId)->count()
            : 0;
        $avgProgress = $totalStudents > 0
            ? round((float) $students->avg('progress'))
            : 0;
        $totalAssessments = $departmentId
            ? Assessments::query()
                ->whereHas('student', fn ($q) => $q->where('department_id', $departmentId))
                ->count()
            : 0;

        $topPerformers = $students
            ->sortByDesc('progress')
            ->take(4)
            ->values();

        $studentIds = $students->pluck('id');

        $enrollmentEvents = $studentIds->isEmpty()
            ? collect()
            : Enrollments::query()
                ->with(['student', 'course'])
                ->whereIn('student_id', $studentIds)
                ->latest('enrolled_at')
                ->limit(10)
                ->get()
                ->map(function ($event) {
                    return (object) [
                        'message' => ($event->student->name ?? 'Student') . ' enrolled in ' . ($event->course->title ?? 'a course'),
                        'time' => optional($event->enrolled_at ?? $event->created_at)->diffForHumans(),
                        'dot' => 'bg-blue-400',
                        'timestamp' => optional($event->enrolled_at ?? $event->created_at)?->timestamp ?? 0,
                    ];
                });

        $lessonEvents = $studentIds->isEmpty()
            ? collect()
            : LessonProgress::query()
                ->with(['student', 'lesson'])
                ->whereIn('student_id', $studentIds)
                ->where('status', 'completed')
                ->whereNotNull('completed_at')
                ->latest('completed_at')
                ->limit(10)
                ->get()
                ->map(function ($event) {
                    return (object) [
                        'message' => ($event->student->name ?? 'Student') . ' completed ' . ($event->lesson->title ?? 'a lesson'),
                        'time' => optional($event->completed_at)->diffForHumans(),
                        'dot' => 'bg-green-400',
                        'timestamp' => optional($event->completed_at)?->timestamp ?? 0,
                    ];
                });

        $assessmentEvents = $studentIds->isEmpty()
            ? collect()
            : Assessments::query()
                ->with('student')
                ->whereIn('student_id', $studentIds)
                ->latest('completed_at')
                ->latest('created_at')
                ->limit(10)
                ->get()
                ->map(function ($event) {
                    $eventTime = $event->completed_at ?? $event->created_at;
                    $scorePct = $event->total_questions > 0
                        ? round(((float) $event->score / (float) $event->total_questions) * 100)
                        : 0;

                    return (object) [
                        'message' => ($event->student->name ?? 'Student') . ' scored ' . $scorePct . '% in ' . strtoupper($event->assessment_type),
                        'time' => optional($eventTime)->diffForHumans(),
                        'dot' => 'bg-amber-400',
                        'timestamp' => optional($eventTime)?->timestamp ?? 0,
                    ];
                });

        $recentDepartmentActivity = $enrollmentEvents
            ->concat($lessonEvents)
            ->concat($assessmentEvents)
            ->sortByDesc(fn ($event) => $event->timestamp ?? 0)
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'admin',
            'department',
            'students',
            'totalStudents',
            'totalCourses',
            'avgProgress',
            'totalAssessments',
            'topPerformers',
            'recentDepartmentActivity',
        ));
    }
}
