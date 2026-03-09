<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessments extends Model
{
    protected $fillable = [
        'student_id',
        'department_id',
        'module_id',
        'assessment_type',
        'is_adaptive',
        'start_difficulty',
        'current_difficulty',
        'difficulty_path',
        'score',
        'total_questions',
        'time_taken',
        'completed_at',
        'started_at',
        'answers',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'started_at' => 'datetime',
        'answers' => 'array',
        'difficulty_path' => 'array',
        'is_adaptive' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function module()
    {
        return $this->belongsTo(Modules::class, 'module_id');
    }

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function attemptAnswers()
    {
        return $this->hasMany(AssessmentAttemptAnswer::class, 'assessment_id');
    }
}
