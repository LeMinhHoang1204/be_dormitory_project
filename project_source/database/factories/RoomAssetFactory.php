<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomAsset>
 */
class RoomAssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['In use', 'Fixing', 'Damaged']),
            'issue_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'note' => $this->faker->sentence,
        ];
    }
}
