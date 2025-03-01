<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
            'uni_id' => $this->faker->unique()->numberBetween(10000, 99999),
            'uni_name' => Arr::random(['DHQGHN', 'DHQGTPHCM', 'BKHN','BKHCM','KTQD','FTU','UEH', 'YHN','YTPHCM']),
            'dob' => $this->faker->dateTimeBetween('-25 years', '-18 years'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'training_point' => rand(50,100),
        ];
    }
}
