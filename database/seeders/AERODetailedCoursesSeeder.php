<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Departments;
use App\Models\Modules;
use App\Models\Question;
use Database\Seeders\Concerns\SeedsRichCourseContent;
use Illuminate\Database\Seeder;

class AERODetailedCoursesSeeder extends Seeder
{
    use SeedsRichCourseContent;

    public function run(): void
    {
        $department = Departments::where('code', 'AERO')->first();
        if (!$department) return;

        $additionalCourses = [
            [
                'title' => 'Advanced Flight Dynamics and Control',
                'description' => 'Master nonlinear flight dynamics, advanced control law design, autopilot systems, and real-time flight simulations.',
                'difficulty' => 'advanced',
                'icon' => '🛩️',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=xzA6bDXdxrE',
            ],
            [
                'title' => 'Hypersonic Aerodynamics and Flight',
                'description' => 'Study high-speed flow regimes, shock interactions, thin-shell structures, and extreme environment design.',
                'difficulty' => 'advanced',
                'icon' => '🚀',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=Z6qI8qvbYI8',
            ],
            [
                'title' => 'Helicopter Aerodynamics and Dynamics',
                'description' => 'Rotorcraft theory, blade dynamics, hover performance, forward flight, and control system design.',
                'difficulty' => 'advanced',
                'icon' => '🚁',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=7s-yqmpbODo',
            ],
            [
                'title' => 'Aircraft Systems Integration',
                'description' => 'Integrate all aircraft systems including electrical, hydraulic, pneumatic, and fly-by-wire architecture.',
                'difficulty' => 'advanced',
                'icon' => '⚙️',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=qOjFMGDfJe8',
            ],
            [
                'title' => 'Supersonic and Transonic Flow',
                'description' => 'High-speed aerodynamics, shock-expansion theory, transonic effects, and supersonic aircraft design.',
                'difficulty' => 'advanced',
                'icon' => '⚡',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=WLUIcQrCMEA',
            ],
        ];

        foreach ($additionalCourses as $courseData) {
            $this->createCourseWithModules($department->id, $courseData);
        }
    }

    private function createCourseWithModules(int $departmentId, array $courseData): void
    {
        $courseData['youtube_link'] = $this->resolveCourseYoutubeLink(
            $courseData['title'],
            $courseData['youtube_link'] ?? null
        );

        $course = Course::updateOrCreate(
            ['title' => $courseData['title'], 'department_id' => $departmentId],
            array_merge($courseData, ['total_modules' => 5])
        );

        $modules = $this->buildModuleBlueprints($course->title, $course->description);

        for ($m = 1; $m <= 5; $m++) {
            $moduleData = $modules[$m];
            $module = Modules::updateOrCreate(
                ['course_id' => $course->id, 'module_number' => $m],
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

            $this->addModuleQuestions($departmentId, $course->id, $module->id, $course->title, $moduleData['topics']);
        }
    }

    private function addModuleQuestions(int $departmentId, int $courseId, int $moduleId, string $courseTitle, array $topics): void
    {
        foreach ($topics as $index => $topic) {
            for ($i = 1; $i <= 3; $i++) {
                Question::updateOrCreate(
                    [
                        'department_id' => $departmentId,
                        'course_id' => $courseId,
                        'module_id' => $moduleId,
                        'question_text' => "{$courseTitle}: {$topic} Knowledge Check {$i}",
                    ],
                    [
                        'topic' => $topic,
                        'difficulty_level' => min(5, $index + 1),
                        'options' => [
                            "{$topic} is fundamental to aerospace engineering",
                            "{$topic} is only theoretical knowledge",
                            "{$topic} has no practical aerospace applications",
                            "{$topic} contradicts modern aerospace practices",
                        ],
                        'correct_option' => "{$topic} is fundamental to aerospace engineering",
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
