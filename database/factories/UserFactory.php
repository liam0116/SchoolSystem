<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'user_name' => $this->faker->unique()->userName,
            'password' => Hash::make('password'), // 使用默认密码
            'role_id' => $this->faker->randomElement([2, 3, 4]), // 假设角色ID为2、3或者4
            'department_id' => $this->faker->randomElement([2, 3]), // 假设部门ID为1或者2
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->unique()->phoneNumber,
            'date_of_birth' => $this->faker->date(),
            'joining_year' => $this->faker->year,
            'identity' => 'Student',
            'id_card' => $this->faker->randomNumber(9, true),
            'passport' => $this->faker->randomNumber(9, true),
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
