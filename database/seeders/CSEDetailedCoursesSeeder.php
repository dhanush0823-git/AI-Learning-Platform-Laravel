<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Departments;
use App\Models\Modules;
use App\Models\Question;
use Database\Seeders\Concerns\SeedsRichCourseContent;
use Illuminate\Database\Seeder;

class CSEDetailedCoursesSeeder extends Seeder
{
    use SeedsRichCourseContent;

    public function run(): void
    {
        $department = Departments::where('code', 'CSE')->first();
        if (!$department) return;

        // Additional CSE courses with more detailed content
        $additionalCourses = [
            [
                'title' => 'DevOps and Cloud Computing',
                'description' => 'Master DevOps practices, containerization, orchestration, CI/CD pipelines, and cloud platforms like AWS and Azure.',
                'difficulty' => 'advanced',
                'icon' => '☁️',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=Wvf0mBNGjXY',
            ],
            [
                'title' => 'Web Security and Ethical Hacking',
                'description' => 'Learn web application security, OWASP top 10, penetration testing, and defensive security practices.',
                'difficulty' => 'advanced',
                'icon' => '🔐',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=66Xp-f-ERJA',
            ],
            [
                'title' => 'Advanced CSS and Web Design',
                'description' => 'Master responsive design, animations, CSS grid, preprocessors, and modern design systems.',
                'difficulty' => 'intermediate',
                'icon' => '🎨',
                'duration' => '7 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=1Rs2ND1ryYc',
            ],
            [
                'title' => 'Node.js and Backend Development',
                'description' => 'Build scalable backend systems with Node.js, Express, and real-time applications.',
                'difficulty' => 'intermediate',
                'icon' => '⚡',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=fBNz5xF-Kx4',
            ],
        ];

        foreach ($additionalCourses as $courseData) {
            $courseData['youtube_link'] = $this->resolveCourseYoutubeLink(
                $courseData['title'],
                $courseData['youtube_link'] ?? null
            );

            $course = Course::updateOrCreate(
                ['title' => $courseData['title'], 'department_id' => $department->id],
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

                // Add questions for each module
                $this->addModuleQuestions($department->id, $course->id, $module->id, $moduleData['title'], $moduleData['topics']);
            }
        }
    }

    private function addModuleQuestions(int $departmentId, int $courseId, int $moduleId, string $moduleTitle, array $topics): void
    {
        foreach ($topics as $index => $topic) {
            for ($i = 1; $i <= 3; $i++) {
                Question::updateOrCreate(
                    [
                        'department_id' => $departmentId,
                        'course_id' => $courseId,
                        'module_id' => $moduleId,
                        'question_text' => "{$moduleTitle} Question {$index}.{$i}: What defines {$topic}?",
                    ],
                    [
                        'topic' => $topic,
                        'difficulty_level' => min(5, $index + 1),
                        'options' => [
                            "{$topic} is essential for modern software development",
                            "{$topic} is only used in legacy systems",
                            "{$topic} has no practical application",
                            "{$topic} is independent of software engineering",
                        ],
                        'correct_option' => "{$topic} is essential for modern software development",
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
