<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Residence>
 */
class ResidenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement([
            'Da dang ky',
            'Da thanh toan',
            'Da nhan phong',
            'Da chuyen nhuong',
            'Da tra phong'
        ]);

        return [
            'room_id' => Room::inRandomOrder()->first()->id,
            'start_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 years'),
            'status' => $status,
            'check_out_date' => $status === 'Da tra phong' ? $this->faker->dateTimeBetween('-1 years', 'now') : null,
            'note' => $this->faker->optional()->sentence(),
        ];
    }
}
