<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Departments;
use App\Models\Modules;
use App\Models\Question;
use Database\Seeders\Concerns\SeedsRichCourseContent;
use Illuminate\Database\Seeder;

class ECEDetailedCoursesSeeder extends Seeder
{
    use SeedsRichCourseContent;

    public function run(): void
    {
        $department = Departments::where('code', 'ECE')->first();
        if (!$department) return;

        $additionalCourses = [
            [
                'title' => 'FPGA Design and Implementation',
                'description' => 'Master FPGA programming with Xilinx and Altera tools, hardware-software co-design, and high-performance computing.',
                'difficulty' => 'advanced',
                'icon' => '🔧',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=tB6OKfXSn60',
            ],
            [
                'title' => 'IoT Systems and Wireless Nodes',
                'description' => 'Design and deploy IoT systems, wireless sensor networks, edge computing, and industrial IoT applications.',
                'difficulty' => 'advanced',
                'icon' => '📡',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=77sI-J4qjYI',
            ],
            [
                'title' => 'Advanced Digital Signal Processing',
                'description' => 'Advanced DSP algorithms, real-time signal processing, filter design, and implementation on embedded systems.',
                'difficulty' => 'advanced',
                'icon' => '📊',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=F3ZeRrL_6lM',
            ],
            [
                'title' => 'Renewable Energy Electronics',
                'description' => 'Electronics for solar, wind, and hybrid renewable energy systems with smart grid integration.',
                'difficulty' => 'intermediate',
                'icon' => '⚡',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=j3VhKKh-cYI',
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

            $this->addModuleQuestions($departmentId, $course->id, $module->id, "ECE {$course->title}", $moduleData['topics']);
        }
    }

    private function addModuleQuestions(int $departmentId, int $courseId, int $moduleId, string $context, array $topics): void
    {
        foreach ($topics as $index => $topic) {
            for ($i = 1; $i <= 3; $i++) {
                Question::updateOrCreate(
                    [
                        'department_id' => $departmentId,
                        'course_id' => $courseId,
                        'module_id' => $moduleId,
                        'question_text' => "{$context} - Understanding {$topic}: Question {$index}.{$i}",
                    ],
                    [
                        'topic' => $topic,
                        'difficulty_level' => min(5, $index + 1),
                        'options' => [
                            "{$topic} is crucial for effective {$context}",
                            "{$topic} is theoretical without practical use",
                            "{$topic} contradicts modern engineering practice",
                            "{$topic} is irrelevant to this discipline",
                        ],
                        'correct_option' => "{$topic} is crucial for effective {$context}",
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
