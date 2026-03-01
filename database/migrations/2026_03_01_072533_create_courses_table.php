<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('department_id')->constrained();
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced']);
            $table->integer('total_modules')->default(5);
            $table->string('icon')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('duration')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}