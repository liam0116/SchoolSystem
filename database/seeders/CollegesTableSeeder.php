<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colleges')->insert([
            ['name' => '工程部分'],
            ['name' => '商學院'],
            ['name' => '工程學院'],
            // 其他学院...
        ]);
    }
}
