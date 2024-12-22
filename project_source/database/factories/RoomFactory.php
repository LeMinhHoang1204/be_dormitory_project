<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(['2', '4', '6', '8', '10']), // số sinh viên tối đa trong phòng
            'unit_price' => $this->faker->randomFloat(2, 500, 2000),
            'member_count' => 0, // hoặc mặc định từ schema
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}