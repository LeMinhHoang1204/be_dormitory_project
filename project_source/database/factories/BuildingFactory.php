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
        $floorNumbers = $this->faker->randomElement([10, 15, 20, 25]);
        return [
            'type' => $this->faker->randomElement(['male', 'female']),
            'floor_numbers' => $floorNumbers,
            'room_numbers' => $floorNumbers * 10,
            'student_count' => 0, 
        ];
    }
}
