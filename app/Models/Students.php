<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Students extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'reg_no', 'name', 'email', 'department_id', 'password', 'level', 'avatar', 'streak_days', 'total_progress','batch'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollments::class, 'student_id');
    }

    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class, 'student_id');
    }

    public function assessments()
    {
        return $this->hasMany(Assessments::class, 'student_id');
    }

    public function analytics()
    {
        return $this->hasOne(LearningAnalytics::class, 'student_id');
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id')
                    ->withPivot('progress', 'completed', 'enrolled_at', 'completed_at')
                    ->withTimestamps();
    }
}
