<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSkillProfile extends Model
{
    protected $fillable = [
        'student_id',
        'topic',
        'mastery_score',
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }
}

