<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 创建一个管理员账户
        User::create([
            'user_name' => 'admin',
            'password' => Hash::make('AdminPassword123@@@'), // 使用 Hash::make 来加密密码
            'role_enum' => 'Admin', // 管理员角色的
            'department_id' => 1, // 部门 ID，这里假设为 1
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone_number' => '1234567890',
            'date_of_birth' => '1980-01-01',
            'joining_year' => '2020',
            'identity' => 'administrative_staff',
            'id_card' => '123456789',
            'passport' => '987654321',
            'country' => 'Example Country',
            'city' => 'Example City',
            'address' => '123 Example Street',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 创建 1 个用户记录
        //User::factory()->count(1)->create();
    }
}
