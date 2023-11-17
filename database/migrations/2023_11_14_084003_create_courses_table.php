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
        Schema::create('courses', function (Blueprint $table) {
            $table->string('course_id', 50)->primary();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('department_id')->on('departments');
            $table->integer('credits');
            $table->integer('total_seats');
            $table->boolean('required');
            $table->boolean('cross_department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
