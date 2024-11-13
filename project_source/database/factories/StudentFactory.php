<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'uni_id' => $this->faker->unique()->numberBetween(1000, 9999),
            'uni_name' => $this->faker->name(),
            'dob' => $this->faker->dateTimeBetween('-25 years', '-18 years'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'training_point' => 100, // Hoặc sử dụng mặc định trong migration
        ];
    }
}
