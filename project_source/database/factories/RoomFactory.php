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
            'building_id' => Building::inRandomOrder()->first()->id,
            'floor_number' => $this->faker->numberBetween(1, 10),
            'type' => $this->faker->randomElement([2, 4, 6, 8]), // số sinh viên tối đa trong phòng
            'unit_price' => $this->faker->randomFloat(2, 500, 2000),
            'member_number' => 0, // hoặc mặc định từ schema
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
