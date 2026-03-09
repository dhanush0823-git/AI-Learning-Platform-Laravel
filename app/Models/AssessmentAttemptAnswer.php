<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentAttemptAnswer extends Model
{
    protected $fillable = [
        'assessment_id',
        'question_id',
        'selected_option',
        'is_correct',
        'time_spent_seconds',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessments::class, 'assessment_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}

