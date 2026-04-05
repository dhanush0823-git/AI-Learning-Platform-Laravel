<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departments;
use App\Models\Course;
use App\Models\Modules;
use App\Models\Lessons;
use App\Models\Students;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@ailearning.local'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@12345'),
                'is_super_admin' => true,
            ]
        );

        // Create Departments
        $departments = [
            ['code' => 'CSE', 'name' => 'Computer Science & Engineering', 'icon' => '💻', 'color' => '#4285F4'],
            ['code' => 'ECE', 'name' => 'Electronics & Communication Engineering', 'icon' => '🔌', 'color' => '#34A853'],
            ['code' => 'AIML', 'name' => 'Artificial Intelligence & Machine Learning', 'icon' => '🤖', 'color' => '#EA4335'],
            ['code' => 'MECH', 'name' => 'Mechanical Engineering', 'icon' => '⚙️', 'color' => '#FBBC05'],
            ['code' => 'AERO', 'name' => 'Aeronautical Engineering', 'icon' => '✈️', 'color' => '#8A2BE2'],
        ];

        foreach ($departments as $dept) {
            Departments::create($dept);
        }

        // Create Courses for each department
        $courses = [
            [
                'title' => 'Python Programming Basics',
                'description' => 'Learn Python fundamentals for engineering applications with hands-on projects',
                'department_code' => 'CSE',
                'difficulty' => 'beginner',
                'icon' => '🐍',
                'duration' => '4 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE'
            ],
            [
                'title' => 'Digital Electronics Fundamentals',
                'description' => 'Introduction to digital circuits, logic gates and basic electronics design',
                'department_code' => 'ECE',
                'difficulty' => 'beginner',
                'icon' => '🔌',
                'duration' => '3 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE'
            ],
            [
                'title' => 'Introduction to AI',
                'description' => 'Basic concepts of Artificial Intelligence, machine learning and neural networks',
                'department_code' => 'AIML',
                'difficulty' => 'beginner',
                'icon' => '🤖',
                'duration' => '4 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YOUR_LINK_HERE'
            ],
            [
                'title' => 'Data Structures & Algorithms',
                'description' => 'Essential data structures and algorithms for problem solving',
                'department_code' => 'CSE',
                'difficulty' => 'intermediate',
                'icon' => '📊',
                'duration' => '6 weeks'
            ],
            [
                'title' => 'Machine Learning Concepts',
                'description' => 'Core machine learning algorithms and models',
                'department_code' => 'AIML',
                'difficulty' => 'intermediate',
                'icon' => '🤖',
                'duration' => '8 weeks'
            ],
        ];

        foreach ($courses as $courseData) {
            $department = Departments::where('code', $courseData['department_code'])->first();
            $course = Course::create([
                'title' => $courseData['title'],
                'description' => $courseData['description'],
                'department_id' => $department->id,
                'difficulty' => $courseData['difficulty'],
                'icon' => $courseData['icon'] ?? null,
                'duration' => $courseData['duration'] ?? null,
                'youtube_link' => $courseData['youtube_link'] ?? null,
                'total_modules' => 5
            ]);

            // Create 5 modules for each course
            for ($i = 1; $i <= 5; $i++) {
                $module = Modules::create([
                    'course_id' => $course->id,
                    'module_number' => $i,
                    'title' => "Module {$i}: " . $course->title . " Part {$i}",
                    'description' => "Detailed content for module {$i}",
                    'duration' => 120
                ]);

                // Create 8 lessons for each module
                for ($j = 1; $j <= 8; $j++) {
                    Lessons::create([
                        'module_id' => $module->id,
                        'lesson_number' => $j,
                        'title' => "Lesson {$j}: Topic {$j}",
                        'content' => "This is the detailed content for lesson {$j}.",
                        'duration' => 15,
                        'lesson_type' => $j % 2 == 0 ? 'video' : 'reading',
                        'video_url' => $j % 2 == 0 ? 'https://www.youtube.com/watch?v=sample' : null
                    ]);
                }
            }
        }

        // Create a sample student
        Students::create([
            'reg_no' => 'STU2024001',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'department_id' => Departments::where('code', 'CSE')->first()->id,
            'password' => Hash::make('password123'),
            'level' => 'intermediate',
            'streak_days' => 7,
            'total_progress' => 45
        ]);

        $this->call(DepartmentDiagnosticQuestionSeeder::class);
        $this->call(ModuleQuestionSeeder::class);
        $this->call(CseAdditionalCoursesSeeder::class);
    }
}
