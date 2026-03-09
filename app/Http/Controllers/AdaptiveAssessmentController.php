<?php

namespace App\Http\Controllers;

use App\Models\AssessmentAttemptAnswer;
use App\Models\Assessments;
use App\Models\Question;
use App\Models\StudentSkillProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdaptiveAssessmentController extends Controller
{
    public function start(Request $request)
    {
        $student = Auth::guard('student')->user();

        $validated = $request->validate([
            'course_id' => ['nullable', 'exists:courses,id'],
            'question_count' => ['nullable', 'integer', 'min:5', 'max:30'],
        ]);

        $questionCount = (int) ($validated['question_count'] ?? 10);
        $startDifficulty = $this->getStartDifficulty($student->level ?? null);

        $assessment = Assessments::create([
            'student_id' => $student->id,
            'department_id' => $student->department_id,
            'assessment_type' => 'test',
            'is_adaptive' => true,
            'start_difficulty' => $startDifficulty,
            'current_difficulty' => $startDifficulty,
            'difficulty_path' => [$startDifficulty],
            'score' => 0,
            'total_questions' => $questionCount,
            'time_taken' => 0,
            'started_at' => now(),
            'answers' => [
                'course_id' => $validated['course_id'] ?? null,
                'responses_count' => 0,
            ],
        ]);

        return redirect()->route('assessments.adaptive.take', $assessment);
    }

    public function take(Assessments $assessment)
    {
        $student = Auth::guard('student')->user();
        abort_unless($assessment->student_id === $student->id && $assessment->is_adaptive, 403);

        return view('assessments.adaptive', compact('assessment'));
    }

    public function nextQuestion(Assessments $assessment)
    {
        $student = Auth::guard('student')->user();
        abort_unless($assessment->student_id === $student->id && $assessment->is_adaptive, 403);

        if ($assessment->completed_at) {
            return response()->json(['done' => true]);
        }

        $responsesCount = (int) ($assessment->answers['responses_count'] ?? 0);
        if ($responsesCount >= (int) $assessment->total_questions) {
            return response()->json(['done' => true]);
        }

        $askedQuestionIds = $assessment->attemptAnswers()->pluck('question_id');

        $query = Question::query()
            ->where('department_id', $assessment->department_id)
            ->where('is_active', true)
            ->where('difficulty_level', (int) $assessment->current_difficulty)
            ->whereNotIn('id', $askedQuestionIds);

        $courseId = $assessment->answers['course_id'] ?? null;
        if ($courseId) {
            $query->where(function ($q) use ($courseId) {
                $q->whereNull('course_id')->orWhere('course_id', $courseId);
            });
        }

        $question = $query->inRandomOrder()->first();

        if (!$question) {
            // Fallback: pick any unanswered question for this department.
            $question = Question::query()
                ->where('department_id', $assessment->department_id)
                ->where('is_active', true)
                ->whereNotIn('id', $askedQuestionIds)
                ->inRandomOrder()
                ->first();
        }

        if (!$question) {
            return response()->json(['done' => true]);
        }

        return response()->json([
            'done' => false,
            'question' => [
                'id' => $question->id,
                'text' => $question->question_text,
                'topic' => $question->topic,
                'difficulty_level' => (int) $question->difficulty_level,
                'options' => $question->options ?? [],
            ],
            'progress' => [
                'answered' => $responsesCount,
                'total' => (int) $assessment->total_questions,
            ],
        ]);
    }

    public function submitAnswer(Request $request, Assessments $assessment)
    {
        $student = Auth::guard('student')->user();
        abort_unless($assessment->student_id === $student->id && $assessment->is_adaptive, 403);

        if ($assessment->completed_at) {
            return response()->json(['message' => 'Assessment already completed.'], 422);
        }

        $validated = $request->validate([
            'question_id' => ['required', 'exists:questions,id'],
            'selected_option' => ['required', 'string'],
            'time_spent_seconds' => ['nullable', 'integer', 'min:0'],
        ]);

        $question = Question::query()
            ->where('id', $validated['question_id'])
            ->where('department_id', $assessment->department_id)
            ->firstOrFail();

        $alreadyAnswered = AssessmentAttemptAnswer::query()
            ->where('assessment_id', $assessment->id)
            ->where('question_id', $question->id)
            ->exists();

        if ($alreadyAnswered) {
            return response()->json(['message' => 'Question already answered.'], 422);
        }

        $isCorrect = strtolower(trim($validated['selected_option'])) === strtolower(trim($question->correct_option));

        $answer = AssessmentAttemptAnswer::create([
            'assessment_id' => $assessment->id,
            'question_id' => $question->id,
            'selected_option' => $validated['selected_option'],
            'is_correct' => $isCorrect,
            'time_spent_seconds' => (int) ($validated['time_spent_seconds'] ?? 0),
        ]);

        $responsesCount = (int) ($assessment->answers['responses_count'] ?? 0) + 1;
        $currentScore = (float) $assessment->score + ($isCorrect ? 1 : 0);
        $currentTime = (int) $assessment->time_taken + (int) $answer->time_spent_seconds;

        $nextDifficulty = $isCorrect
            ? min(5, (int) $assessment->current_difficulty + 1)
            : max(1, (int) $assessment->current_difficulty - 1);

        $difficultyPath = $assessment->difficulty_path ?? [];
        $difficultyPath[] = $nextDifficulty;

        $meta = $assessment->answers ?? [];
        $meta['responses_count'] = $responsesCount;

        $assessment->update([
            'score' => $currentScore,
            'time_taken' => $currentTime,
            'current_difficulty' => $nextDifficulty,
            'difficulty_path' => $difficultyPath,
            'answers' => $meta,
        ]);

        $this->updateSkillProfile($assessment->student_id, $question->topic, $isCorrect);

        $isDone = $responsesCount >= (int) $assessment->total_questions;
        if ($isDone) {
            $this->completeAssessment($assessment);
        }

        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
            'current_difficulty' => $nextDifficulty,
            'done' => $isDone,
        ]);
    }

    public function finish(Assessments $assessment)
    {
        $student = Auth::guard('student')->user();
        abort_unless($assessment->student_id === $student->id && $assessment->is_adaptive, 403);

        if (!$assessment->completed_at) {
            $this->completeAssessment($assessment);
        }

        return response()->json([
            'success' => true,
            'redirect' => route('assessments.adaptive.result', $assessment),
        ]);
    }

    public function result(Assessments $assessment)
    {
        $student = Auth::guard('student')->user();
        abort_unless($assessment->student_id === $student->id && $assessment->is_adaptive, 403);

        $answered = $assessment->attemptAnswers()->count();
        $percentage = $answered > 0 ? round(((float) $assessment->score / $answered) * 100, 2) : 0;
        $weakTopics = $assessment->attemptAnswers()
            ->with('question')
            ->get()
            ->groupBy(fn ($row) => $row->question->topic ?? 'General')
            ->map(function ($rows, $topic) {
                $correct = $rows->where('is_correct', true)->count();
                $total = max(1, $rows->count());
                return (object) [
                    'topic' => $topic,
                    'accuracy' => round(($correct / $total) * 100, 2),
                    'total' => $rows->count(),
                ];
            })
            ->sortBy('accuracy')
            ->take(3)
            ->values();

        return view('assessments.adaptive-result', compact('assessment', 'answered', 'percentage', 'weakTopics'));
    }

    protected function completeAssessment(Assessments $assessment): void
    {
        $answered = $assessment->attemptAnswers()->count();
        $percentage = $answered > 0 ? round(((float) $assessment->score / $answered) * 100, 2) : 0;

        $meta = $assessment->answers ?? [];
        $meta['completed_percentage'] = $percentage;
        $meta['responses_count'] = $answered;

        $assessment->update([
            'completed_at' => now(),
            'answers' => $meta,
        ]);
    }

    protected function getStartDifficulty(?string $level): int
    {
        return match (strtolower((string) $level)) {
            'advanced' => 4,
            'intermediate' => 3,
            default => 1,
        };
    }

    protected function updateSkillProfile(int $studentId, string $topic, bool $isCorrect): void
    {
        $profile = StudentSkillProfile::firstOrCreate(
            ['student_id' => $studentId, 'topic' => $topic ?: 'General'],
            ['mastery_score' => 0]
        );

        $delta = $isCorrect ? 2.5 : -1.5;
        $profile->mastery_score = max(0, min(100, (float) $profile->mastery_score + $delta));
        $profile->save();
    }
}

