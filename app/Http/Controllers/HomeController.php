<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Departments;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $departments = Departments::withCount('courses')->get();
        
        $query = Course::with('department');
        
        if ($request->filled('department') && $request->department !== 'ALL') {
            $query->whereHas('department', function($q) use ($request) {
                $q->where('code', $request->department);
            });
        }
        
        if ($request->filled('difficulty') && $request->difficulty !== 'ALL') {
            $query->where('difficulty', $request->difficulty);
        }
        
        $courses = $query->limit(6)->get();
        
        $foundationCourses = Course::with('department')
            ->where('difficulty', 'beginner')
            ->limit(3)
            ->get();
        
        $aiFeatures = [
            (object)['title' => 'AI Learning Assistant', 'description' => '24/7 personalized guidance and doubt resolution using advanced AI algorithms', 'icon' => '🤖', 'color' => '#4285F4'],
            (object)['title' => 'Smart Progress Tracking', 'description' => 'Real-time analytics and performance insights with predictive learning patterns', 'icon' => '📊', 'color' => '#34A853'],
            (object)['title' => 'Personalized Paths', 'description' => 'AI-driven course recommendations based on your learning style and progress', 'icon' => '🎯', 'color' => '#EA4335'],
            (object)['title' => 'Interactive Content', 'description' => 'Engaging lessons with simulations, quizzes, and hands-on projects', 'icon' => '🔄', 'color' => '#FBBC05']
        ];
        
        $displayDepartments = Departments::whereIn('code', ['CSE', 'ECE', 'AIML', 'MECH', 'AERO'])->get();
        
        return view('home', compact(
            'departments', 
            'courses', 
            'foundationCourses', 
            'aiFeatures',
            'displayDepartments'
        ));
    }
}
