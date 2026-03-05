<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticAttempt;
use App\Models\DiagnosticQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosticTestController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        $latestAttempt = $student->diagnosticAttempts()->latest('completed_at')->first();

        $questions = DiagnosticQuestion::query()
            ->where('department_id', $student->department_id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        if ($questions->isEmpty()) {
            $questions = DiagnosticQuestion::query()
                ->where('is_active', true)
                ->inRandomOrder()
                ->limit(10)
                ->get();
        }

        return view('diagnostic.index', compact('student', 'questions', 'latestAttempt'));
    }

    public function submit(Request $request)
    {
        $student = Auth::guard('student')->user();

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'nullable|in:a,b,c,d',
        ]);

        $answers = $validated['answers'];
        $questionIds = array_keys($answers);

        $questions = DiagnosticQuestion::query()
            ->whereIn('id', $questionIds)
            ->where('department_id', $student->department_id)
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $score = 0;
        foreach ($answers as $questionId => $answer) {
            $question = $questions->get((int) $questionId);
            if ($question && $answer === $question->correct_option) {
                $score++;
            }
        }

        $totalQuestions = max($questions->count(), 1);
        $percentage = round(($score / $totalQuestions) * 100, 2);

        $assignedLevel = match (true) {
            $percentage < 50 => 'beginner',
            $percentage < 80 => 'intermediate',
            default => 'advanced',
        };

        $attempt = DiagnosticAttempt::create([
            'student_id' => $student->id,
            'score' => $score,
            'total_questions' => $questions->count(),
            'percentage' => $percentage,
            'assigned_level' => $assignedLevel,
            'answers' => $answers,
        ]);

        $student->update([
            'level' => $assignedLevel,
        ]);

        return redirect()->route('diagnostic.result', ['attemptId' => $attempt->id]);
    }

    public function result($attemptId)
    {
        $student = Auth::guard('student')->user();

        $attempt = $student->diagnosticAttempts()
            ->where('id', $attemptId)
            ->firstOrFail();

        return view('diagnostic.result', compact('student', 'attempt'));
    }
}
