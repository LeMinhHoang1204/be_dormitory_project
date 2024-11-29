<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = Building::All();

        $buildings->each(function ($building) {
            $floorNumbers = $building->floor_numbers;
            $roomNumbers = $building->room_numbers;
            for ($i = 1; $i <= $floorNumbers; $i++) {
                for ($j = 1; $j <= $roomNumbers / $floorNumbers; $j++) {
                    Room::factory()->state([
                        'floor_number' => $i,
                        'building_id' => $building->id,
                    ])->create();
                }
            }
        });
    }
}
