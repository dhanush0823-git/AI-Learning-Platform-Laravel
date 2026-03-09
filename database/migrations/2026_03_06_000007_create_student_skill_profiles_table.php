<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_skill_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('topic');
            $table->decimal('mastery_score', 5, 2)->default(0);
            $table->timestamps();

            $table->unique(['student_id', 'topic']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_skill_profiles');
    }
};

