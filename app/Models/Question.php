<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'department_id',
        'course_id',
        'topic',
        'difficulty_level',
        'question_text',
        'options',
        'correct_option',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function attemptAnswers()
    {
        return $this->hasMany(AssessmentAttemptAnswer::class, 'question_id');
    }
}

