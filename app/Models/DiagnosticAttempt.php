<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosticAttempt extends Model
{
    protected $fillable = [
        'student_id',
        'score',
        'total_questions',
        'percentage',
        'assigned_level',
        'answers',
        'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }
}
