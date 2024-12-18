<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Violation>
 */
class ViolationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isGeneralViolation = fake()->boolean(30);

        $creator = null;
        $receiver = null;

        if ($isGeneralViolation) {
            $creator = User::whereIn('role', ['admin', 'building manager'])->inRandomOrder()->first();
            $receiver = User::where('role', 'student')
                ->whereHas('latestResidence')
                ->inRandomOrder()
                ->first();
        } else {
            $creator = User::where('role', 'building manager')
                ->whereHas('employee.manageBuilding')
                ->inRandomOrder()
                ->first();

            if ($creator) {
                $building = Building::where('manager_id', $creator->id)->first();

                if ($building) {
                    $receiver = User::where('role', 'student')
                        ->whereHas('latestResidence.room', function ($query) use ($building) {
                            $query->where('building_id', $building->id);
                        })
                        ->inRandomOrder()
                        ->first();
                }
            }
        }

        if (!$creator || !$receiver) {
            $creator = User::where('role', 'admin')->inRandomOrder()->first();
            $receiver = User::where('role', 'student')->inRandomOrder()->first();
        }

        return [
            'creator_id' => $creator->id,
            'receiver_id' => $receiver->id,
            'type' => fake()->randomElement(['Warning', 'Violation']),
            'title' => fake()->sentence(3),
            'description' => fake()->optional()->sentence(),
            'occurred_at' => fake()->dateTimeThisYear(),
            'status' => fake()->randomElement(['Approved', 'Complained']),
            'minus_point' => fake()->numberBetween(1, 5),
            'note' => fake()->optional()->sentence(),
        ];
    }



}
