<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessments extends Model
{
    protected $fillable = [
        'student_id',
        'module_id',
        'assessment_type',
        'score',
        'total_questions',
        'time_taken',
        'completed_at',
        'answers',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'answers' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function module()
    {
        return $this->belongsTo(Modules::class, 'module_id');
    }
}
