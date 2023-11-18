<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['name' => '資訊工程部門', 'college_id' => 1],
            ['name' => '資訊管理系', 'college_id' => 2],
            ['name' => '資訊工程系', 'college_id' => 3],
            // 其他部门...
        ]);
    }
}
