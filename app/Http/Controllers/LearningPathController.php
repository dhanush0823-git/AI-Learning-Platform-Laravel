<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollments;
use App\Models\LessonProgress;
use App\Models\Lessons;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LearningPathController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $courses = $student->enrolledCourses()->with('modules.lessons')->get();

        return view('learn.index', compact('student', 'courses'));
    }

    public function course($id)
    {
        $student = Auth::guard('student')->user();
        $course = Course::with(['department', 'modules.lessons'])->findOrFail($id);

        return view('learn.course', compact('student', 'course'));
    }

    public function startModule($courseId, $moduleId)
    {
        $student = Auth::guard('student')->user();
        $course = Course::with(['modules.lessons'])->findOrFail($courseId);
        $module = $course->modules->firstWhere('id', (int) $moduleId);

        abort_if(! $module, 404);

        $firstLesson = $module->lessons->sortBy('lesson_number')->first();
        abort_if(! $firstLesson, 404, 'No lessons in this module.');

        Enrollments::firstOrCreate(
            ['student_id' => $student->id, 'course_id' => $course->id],
            ['progress' => 0, 'completed' => false]
        );

        return redirect()->route('learn.lesson', [
            'courseId' => $course->id,
            'moduleId' => $module->id,
            'lessonId' => $firstLesson->id,
        ]);
    }

    public function lesson($courseId, $moduleId, $lessonId)
    {
        $student = Auth::guard('student')->user();

        $course = Course::with(['department', 'modules.lessons'])->findOrFail($courseId);
        $module = $course->modules->firstWhere('id', (int) $moduleId);
        abort_if(! $module, 404);

        $lesson = $module->lessons->firstWhere('id', (int) $lessonId);
        abort_if(! $lesson, 404);

        Enrollments::firstOrCreate(
            ['student_id' => $student->id, 'course_id' => $course->id],
            ['progress' => 0, 'completed' => false]
        );

        $lessonProgress = LessonProgress::firstOrCreate(
            ['student_id' => $student->id, 'lesson_id' => $lesson->id],
            ['status' => 'in_progress', 'last_accessed_at' => now()]
        );

        if ($lessonProgress->status === 'not_started') {
            $lessonProgress->status = 'in_progress';
        }
        $lessonProgress->last_accessed_at = now();
        $lessonProgress->save();

        $moduleLessons = $module->lessons->sortBy('lesson_number')->values();
        $lessonStatuses = LessonProgress::query()
            ->where('student_id', $student->id)
            ->whereIn('lesson_id', $moduleLessons->pluck('id'))
            ->get()
            ->keyBy('lesson_id');
        $nextLesson = $this->findNextLesson($course, $module, $lesson);

        return view('learn.lesson', compact(
            'student',
            'course',
            'module',
            'lesson',
            'moduleLessons',
            'lessonStatuses',
            'nextLesson',
            'lessonProgress'
        ));
    }

    public function trackLessonTime(Request $request, $lessonId)
    {
        $student = Auth::guard('student')->user();

        $validated = $request->validate([
            'seconds' => 'required|integer|min:1|max:3600',
        ]);

        $lesson = Lessons::with('module')->findOrFail($lessonId);
        $courseId = $lesson->module->course_id;

        $progress = LessonProgress::firstOrCreate(
            ['student_id' => $student->id, 'lesson_id' => $lesson->id],
            ['status' => 'in_progress']
        );

        if ($progress->status !== 'completed') {
            $progress->status = 'in_progress';
        }

        $progress->time_spent = (int) $progress->time_spent + (int) $validated['seconds'];
        $progress->last_accessed_at = now();
        $progress->save();

        $this->updateCourseProgress($student->id, $courseId);

        return response()->json(['ok' => true]);
    }

    public function completeLesson(Request $request, $courseId, $moduleId, $lessonId)
    {
        $student = Auth::guard('student')->user();
        $course = Course::with(['modules.lessons'])->findOrFail($courseId);
        $module = $course->modules->firstWhere('id', (int) $moduleId);
        abort_if(! $module, 404);

        $lesson = $module->lessons->firstWhere('id', (int) $lessonId);
        abort_if(! $lesson, 404);

        $validated = $request->validate([
            'seconds' => 'nullable|integer|min:0|max:3600',
        ]);

        $progress = LessonProgress::firstOrCreate(
            ['student_id' => $student->id, 'lesson_id' => $lesson->id],
            ['status' => 'in_progress']
        );

        if (! empty($validated['seconds'])) {
            $progress->time_spent = (int) $progress->time_spent + (int) $validated['seconds'];
        }
        $progress->status = 'completed';
        $progress->completed_at = now();
        $progress->last_accessed_at = now();
        $progress->save();

        $this->updateCourseProgress($student->id, $course->id);

        // If the module is completed, direct the student to the module test.
        $moduleLessonIds = $module->lessons->pluck('id');
        $completedModuleLessons = LessonProgress::query()
            ->where('student_id', $student->id)
            ->whereIn('lesson_id', $moduleLessonIds)
            ->where('status', 'completed')
            ->count();

        $moduleIsCompleted = $moduleLessonIds->count() > 0 && $completedModuleLessons >= $moduleLessonIds->count();

        if ($moduleIsCompleted) {
            return redirect()->route('assessments.module.start', [
                'courseId' => $course->id,
                'moduleId' => $module->id,
            ])->with('status', 'Module completed! Please take the module test.');
        }

        $nextLesson = $this->findNextLesson($course, $module, $lesson);

        if ($nextLesson) {
            return redirect()->route('learn.lesson', [
                'courseId' => $course->id,
                'moduleId' => $nextLesson->module_id,
                'lessonId' => $nextLesson->id,
            ]);
        }

        return redirect()
            ->route('learn.course', ['id' => $course->id])
            ->with('status', 'Course completed.');
    }

    protected function updateCourseProgress(int $studentId, int $courseId): void
    {
        $course = Course::with('modules.lessons')->findOrFail($courseId);

        $lessonIds = $course->modules
            ->flatMap(fn ($module) => $module->lessons->pluck('id'))
            ->values();

        $totalLessons = $lessonIds->count();
        if ($totalLessons === 0) {
            return;
        }

        $completedLessons = LessonProgress::query()
            ->where('student_id', $studentId)
            ->whereIn('lesson_id', $lessonIds)
            ->where('status', 'completed')
            ->count();

        $progressPercentage = (int) round(($completedLessons / $totalLessons) * 100);

        Enrollments::updateOrCreate(
            ['student_id' => $studentId, 'course_id' => $courseId],
            [
                'progress' => $progressPercentage,
                'completed' => $completedLessons === $totalLessons,
                'completed_at' => $completedLessons === $totalLessons ? now() : null,
            ]
        );
    }

    protected function findNextLesson(Course $course, $currentModule, $currentLesson): ?Lessons
    {
        $orderedModules = $course->modules->sortBy('module_number')->values();
        $currentModuleIndex = $orderedModules->search(fn ($m) => (int) $m->id === (int) $currentModule->id);

        if ($currentModuleIndex === false) {
            return null;
        }

        $currentModuleLessons = $orderedModules[$currentModuleIndex]->lessons->sortBy('lesson_number')->values();
        $currentLessonIndex = $currentModuleLessons->search(fn ($l) => (int) $l->id === (int) $currentLesson->id);

        if ($currentLessonIndex !== false && isset($currentModuleLessons[$currentLessonIndex + 1])) {
            return $currentModuleLessons[$currentLessonIndex + 1];
        }

        for ($i = $currentModuleIndex + 1; $i < $orderedModules->count(); $i++) {
            $nextModuleLesson = $orderedModules[$i]->lessons->sortBy('lesson_number')->first();
            if ($nextModuleLesson) {
                return $nextModuleLesson;
            }
        }

        return null;
    }
}
