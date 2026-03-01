<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        $progress = (object) [
            'total_courses' => $student->enrolledCourses()->count(),
            'completed_lessons' => $student->lessonProgress()->where('status', 'completed')->count(),
            'average_progress' => round($student->enrolledCourses()->avg('enrollments.progress') ?? 0, 1),
            'streak_days' => $student->streak_days,
        ];

        $courses = $student->enrolledCourses()->get();

        return view('progress.index', compact('student', 'progress', 'courses'));
    }
}
