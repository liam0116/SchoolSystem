<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instructor_course', function (Blueprint $table) {
            $table->integer('instructor_id')->unsigned();
            $table->string('course_id', 50);
            $table->foreign('instructor_id')->references('instructor_id')->on('instructors');
            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->primary(['instructor_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_course');
    }
};
