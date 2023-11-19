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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_name', 255)->unique();
            $table->string('password', 255); // 注意: 在实际应用中应使用 Laravel 的 Hash Facade 进行加密
            $table->string('role_enum', 255);
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('department_id')->on('departments');
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone_number', 255)->unique();
            $table->date('date_of_birth');
            $table->integer('joining_year');
            $table->string('identity', 50);
            $table->string('id_card', 20)->nullable();
            $table->string('passport', 20)->nullable();
            $table->string('country', 255);
            $table->string('city', 255);
            $table->text('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
