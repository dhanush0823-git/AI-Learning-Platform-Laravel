<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('module_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('assessment_type', ['quiz', 'test', 'assignment']);
            $table->float('score')->default(0);
            $table->integer('total_questions')->default(10);
            $table->integer('time_taken')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->json('answers')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessments');
    }
}