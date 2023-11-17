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
        Schema::create('course_periods', function (Blueprint $table) {
            $table->increments('period_id');
            $table->string('period_code', 2);
            $table->integer('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->unique(['period_code', 'day_of_week', 'start_time', 'end_time'], 'course_periods_unique_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_periods');
    }
};
