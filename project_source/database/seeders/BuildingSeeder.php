<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Building::factory(5)->create();

//        // Tạo 4 tòa A B C D
//        $buildingNames = ['A', 'B', 'C', 'D'];
//
//        foreach ($buildingNames as $index => $name) {
//            Building::create([
//                'name' => $name,
//                'type' => $index % 2 == 0 ? 'male' : 'female',
//                'floor_numbers' => [5, 4, 6, 7][$index],
//                'room_numbers' => [50, 40, 60, 70][$index],
//                'student_count' => 0,
//            ]);
//        }
    }
}
