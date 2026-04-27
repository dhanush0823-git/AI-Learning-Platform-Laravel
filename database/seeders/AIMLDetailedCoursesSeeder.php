<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Departments;
use App\Models\Modules;
use App\Models\Question;
use Database\Seeders\Concerns\SeedsRichCourseContent;
use Illuminate\Database\Seeder;

class AIMLDetailedCoursesSeeder extends Seeder
{
    use SeedsRichCourseContent;

    public function run(): void
    {
        $department = Departments::where('code', 'AIML')->first();
        if (!$department) return;

        $additionalCourses = [
            [
                'title' => 'Computer Vision for Real-time Applications',
                'description' => 'Advanced computer vision including real-time object tracking, video analysis, 3D reconstruction, and deployment optimization.',
                'difficulty' => 'advanced',
                'icon' => '📹',
                'duration' => '10 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=IA3WxTeddLs',
            ],
            [
                'title' => 'Conversational AI and Chatbots',
                'description' => 'Build intelligent conversational systems, dialogue management, intent recognition, and deploy on various platforms.',
                'difficulty' => 'intermediate',
                'icon' => '💬',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=8rXD5-xkjFE',
            ],
            [
                'title' => 'Time Series Analysis and Forecasting',
                'description' => 'Master temporal data analysis, ARIMA, Prophet, LSTM networks, and real-world forecasting applications.',
                'difficulty' => 'intermediate',
                'icon' => '📈',
                'duration' => '8 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=vV9mhqK4eLM',
            ],
            [
                'title' => 'Anomaly Detection and Outlier Analysis',
                'description' => 'Detect anomalies using statistical methods, isolation forests, autoencoders, and implement fraud detection systems.',
                'difficulty' => 'advanced',
                'icon' => '🔍',
                'duration' => '7 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=FRM46Y4bk3o',
            ],
            [
                'title' => 'Graph Neural Networks and Knowledge Graphs',
                'description' => 'Work with graph-structured data, GNNs, knowledge graphs, recommendations, and relationship learning.',
                'difficulty' => 'advanced',
                'icon' => '🕸️',
                'duration' => '9 weeks',
                'youtube_link' => 'https://www.youtube.com/watch?v=7qY7ye7YZUM',
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
            for ($i = 1; $i <= 4; $i++) {
                Question::updateOrCreate(
                    [
                        'department_id' => $departmentId,
                        'course_id' => $courseId,
                        'module_id' => $moduleId,
                        'question_text' => "{$courseTitle}: {$topic} Question {$index}",
                    ],
                    [
                        'topic' => $topic,
                        'difficulty_level' => min(5, $index + 1),
                        'options' => [
                            "{$topic} determines the success of AI/ML projects",
                            "{$topic} has minimal impact on model performance",
                            "{$topic} is only relevant in research",
                            "{$topic} contradicts modern AI practices",
                        ],
                        'correct_option' => "{$topic} determines the success of AI/ML projects",
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
