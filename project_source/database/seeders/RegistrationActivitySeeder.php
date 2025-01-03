<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\RegistrationActivity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = Activity::All();

        $activities->each(function ($activity) {
            $registered_participants = $activity->registered_participants;
            $participants = User::where('role', 'student')->inRandomOrder()->limit($registered_participants)->get();
            $currentDate = now();

            for ($i = 1; $i <= $registered_participants; $i++) {
                $status = $currentDate->lessThan($activity->start_date)
                    ? 'Registered'
                    : 'Joined';
                if ($currentDate->lessThan($activity->end_date) && $participants[$i - 1]->has_cancelled) {
                    $status = 'Cancelled';
                }
                RegistrationActivity::factory()->state([
                    'participant_id' => $participants[$i - 1]->id,
                    'activity_id' => $activity->id,
                    'status' => $status,
                ])->create();
            }
        });
    }
}
