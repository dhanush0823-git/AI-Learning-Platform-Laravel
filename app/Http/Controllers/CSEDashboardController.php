<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Departments;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ? Students::with('department')
                ->withCount('enrollments')
                ->where('department_id', $departmentId)
                ->latest()
                ->get()
            : collect();

        $totalStudents = $students->count();
        $totalCourses = $departmentId
            ? Course::where('department_id', $departmentId)->count()
            : 0;
        $avgProgress = $totalStudents > 0
            ? round((float) $students->avg('total_progress'))
            : 0;

        return view('admin.dashboard', compact(
            'admin',
            'department',
            'students',
            'totalStudents',
            'totalCourses',
            'avgProgress',
        ));
    }
}
