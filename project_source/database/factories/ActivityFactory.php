<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $end_date = $this->faker->dateTimeBetween('+1 month', '+2 months');
        return [
            'creator_id' => $this->faker->randomElement(
                User::whereIn('role', ['admin', 'building manager'])->pluck('id')->toArray()
            ),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->text(200),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $end_date,
            'register_end_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'max_participants' => $this->faker->numberBetween(10, 100),
            'registered_participants' => $this->faker->numberBetween(0, 100),
            'ticket_price' => $this->faker->randomFloat(2, 10, 100),
            'bonus_point' => $this->faker->numberBetween(0, 10),
            'status' => $end_date ? 'Done' : $this->faker->randomElement(['Pending', 'Ongoing']),
            'note' => $this->faker->optional()->text(200),
        ];
    }
}
