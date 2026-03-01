<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departments extends Model
{
    protected $fillable = [
        'code',
        'name',
        'icon',
        'color',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'department_id');
    }
}
