<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class LearningPathController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $courses = $student->enrolledCourses()->with('modules.lessons')->get();

        return view('learn.index', compact('student', 'courses'));
    }

    public function course($id)
    {
        $student = Auth::guard('student')->user();
        $course = Course::with(['department', 'modules.lessons'])->findOrFail($id);

        return view('learn.course', compact('student', 'course'));
    }
}
