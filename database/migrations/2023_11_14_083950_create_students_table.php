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
        Schema::create('students', function (Blueprint $table) {
            $table->increments('student_id');
            $table->integer('user_id')->unsigned();
            $table->integer('enrollment_year');
            $table->integer('major_department_id')->unsigned();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('major_department_id')->references('department_id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
