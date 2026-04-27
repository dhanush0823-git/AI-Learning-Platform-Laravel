<?php

namespace Database\Seeders\Concerns;

use App\Models\Lessons;
use App\Models\Modules;

trait SeedsRichCourseContent
{
    protected function resolveCourseYoutubeLink(string $courseTitle, ?string $existingUrl = null): string
    {
        if ($this->isPlaceholderYoutubeUrl($existingUrl)) {
            return $this->buildYoutubeSearchUrl("{$courseTitle} full course tutorial");
        }

        return $existingUrl;
    }

    protected function buildModuleBlueprints(string $courseTitle, string $courseDescription, array $existingModules = []): array
    {
        $stages = [
            1 => ['label' => 'Foundations', 'summary' => 'Build the core vocabulary, context, and principles for the course.'],
            2 => ['label' => 'Core Methods', 'summary' => 'Study the main methods, models, or engineering workflow used in the subject.'],
            3 => ['label' => 'Tools and Implementation', 'summary' => 'Translate theory into tools, components, and implementation patterns.'],
            4 => ['label' => 'Analysis and Optimization', 'summary' => 'Measure performance, troubleshoot issues, and optimize design decisions.'],
            5 => ['label' => 'Projects and Practice', 'summary' => 'Apply the course in case studies, mini projects, and review activities.'],
        ];

        $blueprints = [];

        foreach ($stages as $moduleNumber => $stage) {
            $moduleData = $existingModules[$moduleNumber] ?? [];
            $title = $moduleData['title'] ?? "Module {$moduleNumber}: {$stage['label']} of {$courseTitle}";
            $description = $moduleData['description'] ?? "{$stage['summary']} Focused on {$courseTitle}.";
            $topics = $this->normalizeTopics(
                $moduleData['topics'] ?? [],
                $courseTitle,
                $title,
                $description,
                $moduleNumber
            );

            $blueprints[$moduleNumber] = [
                'title' => $title,
                'description' => $description,
                'topics' => $topics,
                'lessons' => $moduleData['lessons'] ?? [],
            ];
        }

        return $blueprints;
    }

    protected function syncModuleLessons(
        Modules $module,
        string $courseTitle,
        string $moduleTitle,
        string $moduleDescription,
        array $topics = [],
        array $customLessons = [],
        int $targetCount = 14
    ): void {
        $lessonPlan = $this->buildLessonPlan(
            $courseTitle,
            $moduleTitle,
            $moduleDescription,
            $topics,
            $customLessons,
            $targetCount
        );

        foreach ($lessonPlan as $index => $lessonData) {
            Lessons::updateOrCreate(
                [
                    'module_id' => $module->id,
                    'lesson_number' => $index + 1,
                ],
                [
                    'title' => $lessonData['title'],
                    'content' => $this->expandLessonContent(
                        $courseTitle,
                        $moduleTitle,
                        $lessonData['title'],
                        $lessonData['content'],
                        $lessonData['type']
                    ),
                    'lesson_type' => $lessonData['type'],
                    'duration' => $lessonData['duration'],
                    'video_url' => $this->sanitizeLessonVideoUrl(
                        $lessonData['type'],
                        $lessonData['video_url']
                    ),
                ]
            );
        }

        Lessons::where('module_id', $module->id)
            ->where('lesson_number', '>', count($lessonPlan))
            ->delete();
    }

    protected function normalizeTopics(
        array $topics,
        string $courseTitle,
        string $moduleTitle,
        string $moduleDescription,
        int $moduleNumber
    ): array {
        if (!empty($topics)) {
            return array_values(array_slice($topics, 0, 8));
        }

        $topicSets = [
            1 => [
                "Overview of {$courseTitle}",
                "Key terminology in {$courseTitle}",
                "Engineering context for {$courseTitle}",
                "Fundamental concepts in {$moduleTitle}",
                'Prerequisites and baseline skills',
                'Learning roadmap and expected outcomes',
                'Core examples and worked illustrations',
                'How this module connects to later modules',
            ],
            2 => [
                "Core principles of {$courseTitle}",
                "Methods used in {$moduleTitle}",
                'Component interactions and workflow',
                'Design constraints and assumptions',
                'Typical calculations and reasoning steps',
                'Common mistakes and how to avoid them',
                'Intermediate practice patterns',
                'Comparison of alternative approaches',
            ],
            3 => [
                "Tools and platforms for {$courseTitle}",
                "Implementation flow for {$moduleTitle}",
                'Configuration and setup process',
                'Integration with related systems',
                'Debugging and verification practices',
                'Hands-on build sequence',
                'Quality checks and review checkpoints',
                'Documentation and collaboration workflow',
            ],
            4 => [
                "Performance analysis for {$courseTitle}",
                "Testing and validation in {$moduleTitle}",
                'Optimization strategies',
                'Interpretation of results',
                'Risk reduction and troubleshooting',
                'Trade-off analysis and decision making',
                'Failure cases and recovery methods',
                'Metrics, reporting, and review standards',
            ],
            5 => [
                "Applied case studies in {$courseTitle}",
                "Project planning for {$moduleTitle}",
                'Documentation and reporting',
                'Review of advanced scenarios',
                'Assessment and self-evaluation',
                'Career and industry applications',
                'Portfolio or lab-ready deliverables',
                'Final revision and mastery roadmap',
            ],
        ];

        return $topicSets[$moduleNumber] ?? [
            $moduleTitle,
            $moduleDescription,
            "{$courseTitle} applications",
            "{$courseTitle} workflow",
            "{$courseTitle} troubleshooting",
            "{$courseTitle} review",
            "{$courseTitle} project delivery",
            "{$courseTitle} advanced practice",
        ];
    }

    protected function buildLessonPlan(
        string $courseTitle,
        string $moduleTitle,
        string $moduleDescription,
        array $topics = [],
        array $customLessons = [],
        int $targetCount = 14
    ): array {
        $topics = array_values($topics);
        $topics = !empty($topics) ? $topics : [
            $moduleTitle,
            "{$courseTitle} fundamentals",
            "{$courseTitle} workflow",
            "{$courseTitle} implementation",
            "{$courseTitle} analysis",
            "{$courseTitle} project practice",
            "{$courseTitle} optimization",
            "{$courseTitle} final revision",
        ];

        $defaults = [
            [
                'title' => "Introduction to {$moduleTitle}",
                'content' => "Get oriented to {$moduleTitle} and understand how it supports the wider {$courseTitle} learning path. This lesson introduces the scope, expected outcomes, and the engineering mindset required for the module.",
                'type' => 'reading',
                'duration' => 15,
                'video_url' => null,
            ],
            [
                'title' => "Concept Walkthrough: {$topics[0]}",
                'content' => "This video-style lesson explains {$topics[0]} with practical framing, examples, and terminology that learners will reuse throughout {$courseTitle}.",
                'type' => 'video',
                'duration' => 18,
                'video_url' => 'https://www.youtube.com/watch?v=sample',
            ],
            [
                'title' => "Theory Notes: {$topics[1]}",
                'content' => "Study the theory behind {$topics[1]} and connect it to the objectives of {$moduleTitle}. The focus is on principles, definitions, and where the concept appears in real technical work.",
                'type' => 'reading',
                'duration' => 16,
                'video_url' => null,
            ],
            [
                'title' => "Knowledge Check: {$moduleTitle}",
                'content' => "A short quiz that checks understanding of the first half of {$moduleTitle}, including {$topics[0]} and {$topics[1]}.",
                'type' => 'quiz',
                'duration' => 10,
                'video_url' => null,
            ],
            [
                'title' => "Applied Workflow: {$topics[2]}",
                'content' => "Follow a guided workflow around {$topics[2]} and see how concepts from {$courseTitle} move from theory into implementation decisions.",
                'type' => 'video',
                'duration' => 20,
                'video_url' => 'https://www.youtube.com/watch?v=sample',
            ],
            [
                'title' => "Design and Implementation: {$topics[3]}",
                'content' => "Break down {$topics[3]} into steps, dependencies, and validation checks. This lesson uses the module description as a bridge between concept and execution: {$moduleDescription}",
                'type' => 'reading',
                'duration' => 18,
                'video_url' => null,
            ],
            [
                'title' => "Troubleshooting Guide: {$topics[4]}",
                'content' => "Learn how to detect common issues around {$topics[4]}, evaluate root causes, and choose corrective actions that improve quality and consistency.",
                'type' => 'reading',
                'duration' => 17,
                'video_url' => null,
            ],
            [
                'title' => "Module Review Quiz: {$topics[5]}",
                'content' => "This quiz reinforces the later concepts in {$moduleTitle} and tests readiness for project-oriented work and advanced modules.",
                'type' => 'quiz',
                'duration' => 12,
                'video_url' => null,
            ],
            [
                'title' => "Case Study Lab: {$courseTitle}",
                'content' => "Work through a case study that combines multiple ideas from {$moduleTitle}. Learners interpret requirements, make technical choices, and review the outcome using domain-appropriate criteria.",
                'type' => 'video',
                'duration' => 22,
                'video_url' => 'https://www.youtube.com/watch?v=sample',
            ],
            [
                'title' => "Capstone Prep and Reflection for {$moduleTitle}",
                'content' => "Close the module with revision prompts, project preparation notes, and a checklist of skills gained across {$moduleTitle} in {$courseTitle}.",
                'type' => 'reading',
                'duration' => 15,
                'video_url' => null,
            ],
            [
                'title' => "Worked Example Session: {$topics[6]}",
                'content' => "Follow a complete worked example centered on {$topics[6]}. This lesson slows the workflow down step by step so learners can see decisions, intermediate checks, and expected outputs clearly.",
                'type' => 'video',
                'duration' => 19,
                'video_url' => 'https://www.youtube.com/watch?v=sample',
            ],
            [
                'title' => "Practice Problems: {$topics[1]} and {$topics[4]}",
                'content' => "Solve structured practice problems that combine {$topics[1]} with {$topics[4]}. Emphasis is placed on method selection, clean reasoning, and checking the quality of the final answer.",
                'type' => 'reading',
                'duration' => 18,
                'video_url' => null,
            ],
            [
                'title' => "Mini Project Brief: {$topics[7]}",
                'content' => "This lesson introduces a mini project based on {$topics[7]}. Learners define scope, gather inputs, choose tools, and map out a clear implementation plan before execution.",
                'type' => 'reading',
                'duration' => 16,
                'video_url' => null,
            ],
            [
                'title' => "Mastery Checkpoint: {$moduleTitle}",
                'content' => "A deeper quiz that checks conceptual understanding, applied decision-making, and readiness to connect this module with the rest of {$courseTitle}.",
                'type' => 'quiz',
                'duration' => 12,
                'video_url' => null,
            ],
        ];

        $lessonPlan = [];

        foreach ($customLessons as $lessonData) {
            $lessonPlan[] = [
                'title' => $lessonData['title'] ?? "Lesson for {$moduleTitle}",
                'content' => $lessonData['content'] ?? "Detailed lesson content for {$moduleTitle}.",
                'type' => $lessonData['type'] ?? 'reading',
                'duration' => $lessonData['duration'] ?? 15,
                'video_url' => $this->resolveLessonYoutubeLink(
                    $courseTitle,
                    $moduleTitle,
                    $lessonData['title'] ?? "Lesson for {$moduleTitle}",
                    $lessonData['video_url'] ?? null,
                    $lessonData['type'] ?? 'reading'
                ),
            ];
        }

        $defaultIndex = 0;
        while (count($lessonPlan) < $targetCount) {
            $lessonPlan[] = $defaults[$defaultIndex % count($defaults)];
            $defaultIndex++;
        }

        return array_map(
            fn (array $lessonData) => [
                'title' => $lessonData['title'],
                'content' => $lessonData['content'],
                'type' => $lessonData['type'],
                'duration' => $lessonData['duration'],
                'video_url' => $this->resolveLessonYoutubeLink(
                    $courseTitle,
                    $moduleTitle,
                    $lessonData['title'],
                    $lessonData['video_url'] ?? null,
                    $lessonData['type']
                ),
            ],
            array_slice($lessonPlan, 0, $targetCount)
        );
    }

    protected function resolveLessonYoutubeLink(
        string $courseTitle,
        string $moduleTitle,
        string $lessonTitle,
        ?string $existingUrl = null,
        string $lessonType = 'reading'
    ): string {
        if ($lessonType !== 'video') {
            return '';
        }

        if ($this->isPlaceholderYoutubeUrl($existingUrl)) {
            return $this->buildYoutubeSearchUrl("{$courseTitle} {$moduleTitle} {$lessonTitle}");
        }

        return $existingUrl;
    }

    protected function sanitizeLessonVideoUrl(string $lessonType, ?string $videoUrl): string
    {
        if ($lessonType !== 'video') {
            return '';
        }

        return (string) $videoUrl;
    }

    protected function expandLessonContent(
        string $courseTitle,
        string $moduleTitle,
        string $lessonTitle,
        string $baseContent,
        string $lessonType
    ): string {
        $baseContent = trim($baseContent);

        if ($lessonType === 'quiz') {
            return $baseContent . "\n\nThis checkpoint should be used to test recall, interpretation, and application. Encourage learners to explain why an answer is correct, compare it with common distractors, and revisit weak areas in {$moduleTitle} before moving ahead.\n\nAfter attempting the quiz, learners should review missed ideas, write down the concepts they are still unsure about, and connect the quiz questions back to real use cases from {$courseTitle}.";
        }

        if ($lessonType === 'video') {
            return $baseContent . "\n\nWhile watching, learners should pause at key transitions, note the sequence of steps being demonstrated, and compare the explanation with the theory introduced earlier in {$moduleTitle}. The goal is not only to follow the demonstration but to understand why each decision is being made.\n\nA strong follow-up activity is to repeat the workflow independently, write a short summary of the process, and identify which parts of the demonstration are most important for practical work in {$courseTitle}.";
        }

        return $baseContent . "\n\nIn this reading lesson, learners should focus on definitions, relationships between ideas, and the reason this concept matters inside {$moduleTitle}. The material should be read actively: pause after each section, restate the concept in simpler words, and connect it to an example or engineering situation where it would appear.\n\nTo make the lesson more useful for revision, learners should extract the main principles, note any formulas, workflows, or design rules, and compare them with similar ideas from other parts of {$courseTitle}. This builds deeper understanding instead of just short-term recall.\n\nBy the end of {$lessonTitle}, the learner should be able to explain the topic clearly, identify where it fits in the broader course, and use the reading as a foundation for later videos, quizzes, and applied tasks.";
    }

    protected function isPlaceholderYoutubeUrl(?string $url): bool
    {
        if ($url === null || trim($url) === '') {
            return true;
        }

        return str_contains($url, 'YOUR_LINK_HERE') || str_contains($url, 'watch?v=sample');
    }

    protected function buildYoutubeSearchUrl(string $query): string
    {
        $normalized = preg_replace('/[^A-Za-z0-9\s]/', ' ', $query) ?? $query;
        $normalized = preg_replace('/\s+/', ' ', trim($normalized)) ?? trim($query);
        $normalized = substr($normalized, 0, 70);

        return 'https://www.youtube.com/results?search_query=' . rawurlencode($normalized);
    }
}
