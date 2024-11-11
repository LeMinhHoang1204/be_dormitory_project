<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'building_manager_id' => User::where('role', 'building-manager')->inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement(['male', 'female']),
            'floor_numbers' => $this->faker->numberBetween(10, 20),
            'room_numbers' => $this->faker->numberBetween(100, 500),
            'student_count' => 0, // hoặc mặc định từ schema
        ];
    }
}
