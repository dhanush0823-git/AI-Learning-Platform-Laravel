<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->boolean('is_adaptive')->default(false)->after('assessment_type');
            $table->tinyInteger('start_difficulty')->default(1)->after('is_adaptive');
            $table->tinyInteger('current_difficulty')->default(1)->after('start_difficulty');
            $table->json('difficulty_path')->nullable()->after('current_difficulty');
            $table->foreignId('department_id')->nullable()->after('student_id')->constrained('departments')->nullOnDelete();
            $table->timestamp('started_at')->nullable()->after('completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('department_id');
            $table->dropColumn([
                'is_adaptive',
                'start_difficulty',
                'current_difficulty',
                'difficulty_path',
                'started_at',
            ]);
        });
    }
};

