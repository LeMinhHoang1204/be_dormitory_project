<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Notification;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'student')->get();
        foreach ($users as $user) {
            Notification::factory()->state([
                'object_id' => $user->id,
                'object_type' => get_class($user), // Dynamically set type
            ])->create();
        }

        $buildings = Building::All(); // Related object
        foreach ($buildings as $building) {
            Notification::factory()->state([
                'object_id' => $building->id,
                'object_type' => get_class($building), // Dynamically set type
            ])->create();
        }

        $rooms = Room::orderBy('id', 'asc')->take(100)->get();
        foreach ($rooms as $room) {
            Notification::factory()->state([
                'object_id' => $room->id,
                'object_type' => get_class($room), // Dynamically set type
            ])->create();
        }
    }
}
