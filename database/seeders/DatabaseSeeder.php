<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 顺序不能错
            CollegesTableSeeder::class, // 學院模擬數據
            DepartmentsTableSeeder::class, // 系級模擬數據
            UserSeeder::class, // 用戶模擬數據
            // 其他 Seeder...
        ]);
    }
}
