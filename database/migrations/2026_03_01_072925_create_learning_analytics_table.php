<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningAnalyticsTable extends Migration
{
    public function up()
    {
        Schema::create('learning_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('skill_name');
            $table->integer('score')->default(0);
            $table->enum('risk_level', ['low', 'medium', 'high'])->default('low');
            $table->json('weak_topics')->nullable();
            $table->json('recommendations')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_analytics');
    }
}