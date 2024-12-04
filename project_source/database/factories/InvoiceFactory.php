<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paidDate = $this->faker->optional()->dateTimeBetween('now', '+1 week');
        return [
            'send_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'paid_date' => $paidDate,
            'type' => $this->faker->randomElement(['Room', 'Electricity', 'Water', 'Fixing', 'Cleaning']),
            'status' => $paidDate ? 'Paid' : $this->faker->randomElement(['Not Paid', 'Overdue', 'Transferred Room']),
            'total' => $this->faker->randomFloat(2, 100, 5000),
            'payment_method' => $this->faker->randomElement(['Cash', 'Bank Transfer']),
            'note' => $this->faker->optional()->text(200),
        ];
    }
}
