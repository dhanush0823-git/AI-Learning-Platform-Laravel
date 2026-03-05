<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lessons extends Model
{
    protected $fillable = [
        'module_id',
        'lesson_number',
        'title',
        'content',
        'lesson_type',
        'duration',
        'video_url',
    ];

    public function module()
    {
        return $this->belongsTo(Modules::class, 'module_id');
    }

    public function progress()
    {
        return $this->hasMany(LessonProgress::class, 'lesson_id');
    }
}
