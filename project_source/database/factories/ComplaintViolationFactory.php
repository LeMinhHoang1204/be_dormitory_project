<?php

namespace Database\Factories;

use App\Models\ComplaintViolation;
use App\Models\User;
use App\Models\Violation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ComplaintViolation>
 */
class ComplaintViolationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ComplaintViolation::class;

    public function definition()
    {
        $violation = Violation::inRandomOrder()->first();

        return [
            'violation_id' => $violation->id,
            'student_id' => $violation->receiver_id,
            'creator_id' => $violation->creator_id,
            'complaint_description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['Pending', 'Accept','Decline']),
        ];
    }
}
