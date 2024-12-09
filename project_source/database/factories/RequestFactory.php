<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'receiver_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'type' => $this->faker->randomElement(['Change Room', 'Renewal', 'Check out', 'Fixing', 'Suggestion', 'Complaint']),
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
            'resolve_date' =>  $this->faker->dateTimeBetween('now', '+1 month'),
            'note' => $this->faker->optional()->text(200),
            'forwarder_id' => $this->faker->optional()->randomElement(User::pluck('id')->toArray()),
        ];
    }
}
