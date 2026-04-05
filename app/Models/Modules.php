<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $fillable = [
        'course_id',
        'module_number',
        'title',
        'description',
        'duration',
        'completed',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lessons::class, 'module_id')->orderBy('lesson_number');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'module_id');
    }
}
