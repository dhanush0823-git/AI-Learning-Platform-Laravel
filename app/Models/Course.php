<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title', 'description', 'department_id', 'difficulty', 
        'total_modules', 'icon', 'youtube_link', 'duration'
    ];

    protected $casts = [
        'difficulty' => 'string'
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function modules()
    {
        return $this->hasMany(Modules::class, 'course_id')->orderBy('module_number');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollments::class);
    }

    public function students()
    {
        return $this->belongsToMany(Students::class, 'enrollments', 'course_id', 'student_id')
                    ->withPivot('progress', 'completed', 'enrolled_at', 'completed_at')
                    ->withTimestamps();
    }
}
