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

        $max_participants = $this->faker->numberBetween(5, 100);
        $is_full = $this->faker->boolean(40);
        if ($is_full) {
            $registered_participants = $max_participants;
        } else {
            $registered_participants = $this->faker->numberBetween(0, $max_participants);
        }
        $start_date = $this->faker->dateTimeBetween('2024-06-30', '2025-2-01');
        $end_date = (clone $start_date)->modify('+' . $this->faker->numberBetween(5, 50) . ' days');
        $register_end_date = $this->faker->dateTimeBetween($start_date->modify('-30 days'), $start_date->modify('-5 days'));
        return [
            'creator_id' => $this->faker->randomElement(
                User::whereIn('role', ['admin', 'building manager'])->pluck('id')->toArray()
            ),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->text(200),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'register_end_date' => $register_end_date,
            'max_participants' => $max_participants,
            'registered_participants' => $registered_participants,
            'ticket_price' => $this->faker->randomFloat(2, 10, 100),
            'bonus_point' => $this->faker->numberBetween(0, 10),
            'status' => now()->greaterThan($end_date)
                ? 'Done'
                : (now()->between($start_date, $end_date) ? 'Ongoing' : 'Pending'),
            'note' => $this->faker->optional()->text(200),
        ];
    }
}
