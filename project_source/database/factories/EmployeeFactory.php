<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'citizen_id' => $this->faker->unique()->numerify('##########'), // Tạo ID công dân ngẫu nhiên
            'dob' => $this->faker->dateTimeBetween('-60 years', '-22 years'), // Ngày sinh từ 22-60 tuổi
            'gender' => $this->faker->randomElement(['male', 'female']),
        ];
    }
}
