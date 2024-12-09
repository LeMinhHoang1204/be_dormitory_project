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
            'sender_id' => $this->faker->randomElement(
                User::whereIn('role', ['admin', 'building manager', 'accountant'])->pluck('id')->toArray()
            ),
            'title' => $this->faker->text(20),
            'content' => $this->faker->text(200),
            'reader_count' => $this->faker->numberBetween(0, 100),
//            'created_at' => now(),
        ];
    }
}
