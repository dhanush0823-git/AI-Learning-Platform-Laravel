<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departments;
use App\Models\Course;
use App\Models\Modules;
use App\Models\Students;
use App\Models\User;
use Database\Seeders\Concerns\SeedsRichCourseContent;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use SeedsRichCourseContent;

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
            Departments::updateOrCreate(
                ['code' => $dept['code']],
                $dept
            );
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
            $course = Course::updateOrCreate(
                ['title' => $courseData['title'], 'department_id' => $department->id],
                [
                    'description' => $courseData['description'],
                    'difficulty' => $courseData['difficulty'],
                    'icon' => $courseData['icon'] ?? null,
                    'duration' => $courseData['duration'] ?? null,
                    'youtube_link' => $this->resolveCourseYoutubeLink(
                        $courseData['title'],
                        $courseData['youtube_link'] ?? null
                    ),
                    'total_modules' => 5,
                ]
            );

            $modules = $this->buildModuleBlueprints($course->title, $course->description);

            // Create 5 modules for each course
            for ($i = 1; $i <= 5; $i++) {
                $moduleData = $modules[$i];
                $module = Modules::updateOrCreate(
                    ['course_id' => $course->id, 'module_number' => $i],
                    [
                        'title' => $moduleData['title'],
                        'description' => $moduleData['description'],
                        'duration' => 120,
                    ]
                );

                $this->syncModuleLessons(
                    $module,
                    $course->title,
                    $moduleData['title'],
                    $moduleData['description'],
                    $moduleData['topics'],
                    $moduleData['lessons'],
                    14
                );
            }
        }

        // Create a sample student
        Students::updateOrCreate(
            ['email' => 'john@example.com'],
            [
                'reg_no' => 'STU2024001',
                'name' => 'John Doe',
                'department_id' => Departments::where('code', 'CSE')->first()->id,
                'password' => Hash::make('password123'),
                'level' => 'intermediate',
                'streak_days' => 7,
                'total_progress' => 45,
            ]
        );

        $this->call(ComprehensiveCoursesSeeder::class);
        $this->call(CSEDetailedCoursesSeeder::class);
        $this->call(ECEDetailedCoursesSeeder::class);
        $this->call(AIMLDetailedCoursesSeeder::class);
        $this->call(MECHDetailedCoursesSeeder::class);
        $this->call(AERODetailedCoursesSeeder::class);
        $this->call(DepartmentDiagnosticQuestionSeeder::class);
        $this->call(ModuleQuestionSeeder::class);
    }
}
