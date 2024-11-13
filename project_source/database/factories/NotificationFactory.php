<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'object_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'object_type' => $this->faker->randomElement(['user', 'building', 'room']),
            'type' => $this->faker->randomElement(['individual', 'group']),
            'title' => $this->faker->text(20),
            'content' => $this->faker->text(200),
            'created_at' => now(),
        ];
    }
}
