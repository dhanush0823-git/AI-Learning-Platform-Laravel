<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $courses = $student->enrolledCourses()->with('modules')->get();

        return view('assessments.index', compact('student', 'courses'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        return redirect()->route('assessments')->with('status', 'Assessment submitted successfully.');
    }
}
