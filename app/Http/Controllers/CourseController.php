<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $departments = Departments::all();
        $student = Auth::guard('student')->user();

        if ($student) {
            $courses = Course::with('department')
                ->where('department_id', $student->department_id)
                ->get();
        } else {
            $query = Course::with('department');
        
            if ($request->filled('department') && $request->department !== 'ALL') {
                $query->whereHas('department', function ($q) use ($request) {
                    $q->where('code', $request->department);
                });
            }
            
            if ($request->filled('difficulty') && $request->difficulty !== 'ALL') {
                $query->where('difficulty', $request->difficulty);
            }
            
            $courses = $query->get();
        }
        
        $difficulties = [
            (object)['value' => 'ALL', 'name' => 'All Levels'],
            (object)['value' => 'beginner', 'name' => 'Beginner', 'color' => '#34A853'],
            (object)['value' => 'intermediate', 'name' => 'Intermediate', 'color' => '#FBBC05'],
            (object)['value' => 'advanced', 'name' => 'Advanced', 'color' => '#EA4335']
        ];
        
        return view('courses', compact('courses', 'departments', 'difficulties'));
    }

    public function show($id)
    {
        $course = Course::with(['department', 'modules.lessons'])->findOrFail($id);
        return view('courses.show', compact('course'));
    }
}
