<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Violation>
 */
class ViolationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'creator_id' => $this->faker->randomElement(
                User::whereIn('role', ['admin', 'building manager'])->pluck('id')->toArray()
            ),
            'receiver_id' => $this->faker->randomElement(
                User::where('role', 'student')->pluck('id')->toArray()
            ),
            'type' => $this->faker->randomElement(['Warning', 'Violation']),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->text(200),
            'occurred_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => $this->faker->randomElement(['Approved', 'Complained']),
            'minus_point' => $this->faker->numberBetween(1, 10),
            'note' => $this->faker->optional()->text(200),
        ];
    }
}
