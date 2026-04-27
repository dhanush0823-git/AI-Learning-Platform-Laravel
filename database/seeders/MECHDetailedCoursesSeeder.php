<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Departments;
use App\Models\Modules;
use App\Models\Question;
use Database\Seeders\Concerns\SeedsRichCourseContent;
use Illuminate\Database\Seeder;

class MECHDetailedCoursesSeeder extends Seeder
{
    use SeedsRichCourseContent;

    public function run(): void
    {
        $department = Departments::where('code', 'MECH')->first();
        if (!$department) return;

        $additionalCourses = [
            [
                'title' => 'Advanced Materials Science and Engineering',
                'description' => 'Master material properties, phase diagrams, crystallography, nanomaterials, and material selection for advanced applications.',
                'difficulty' => 'advanced',
                'icon' => '🔬',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=dJHV3yOmm3Q',
            ],
            [
                'title' => 'HVAC Systems Design and Optimization',
                'description' => 'Design heating, ventilation, air conditioning systems with analysis of load calculations and energy efficiency.',
                'difficulty' => 'intermediate',
                'icon' => '❄️',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=8TwmAGAx3aQ',
            ],
            [
                'title' => 'Vibration Analysis and Dynamics',
                'description' => 'Advanced vibration theory, modal analysis, vibration isolation, and troubleshooting mechanical systems.',
                'difficulty' => 'advanced',
                'icon' => '〰️',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=cX8yP0gqpFQ',
            ],
            [
                'title' => 'Six Sigma and Continuous Improvement',
                'description' => 'Lean Six Sigma methodologies, statistical process control, design of experiments, and quality improvement projects.',
                'difficulty' => 'intermediate',
                'icon' => '⭐',
                'duration' => '7 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=I4Qu_NNqnNU',
            ],
            [
                'title' => 'Product Design and Development',
                'description' => 'Comprehensive product development lifecycle, design thinking, prototyping, testing, and commercialization.',
                'difficulty' => 'intermediate',
                'icon' => '🏗️',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=YO-Ej5aGh0A',
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
                        'question_text' => "{$courseTitle}: How does {$topic} affect design quality?",
                    ],
                    [
                        'topic' => $topic,
                        'difficulty_level' => min(5, $index + 1),
                        'options' => [
                            "{$topic} is critical for successful engineering designs",
                            "{$topic} has no impact on final product quality",
                            "{$topic} is only relevant for research purposes",
                            "{$topic} contradicts engineering best practices",
                        ],
                        'correct_option' => "{$topic} is critical for successful engineering designs",
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
