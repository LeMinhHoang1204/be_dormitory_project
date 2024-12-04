<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Building::factory(5)->create();

        // Tạo 10 tòa nhà
        for ($i = 0; $i < 10; $i++) {
            $floorNumbers = rand(3, 11);
            $roomNumbers = $floorNumbers * 10; // (10 phòng mỗi tầng)
            Building::create([
                'build_name' => $this->generateRandomBuildingName(),
                'manager_id' => \App\Models\User::where('role', 'admin')->inRandomOrder()->first()->id ?? null,
                'type' => ['male', 'female'][array_rand(['male', 'female'])],
                'floor_numbers' => $floorNumbers,
                'room_numbers' => $roomNumbers,
            ]);
        }
    }

    private function generateRandomBuildingName(): string
    {
        $letters = 'ABCDEFGH';
        $numbers = '123456789';

        $letter = $letters[rand(0, strlen($letters) - 1)];

        $number = $numbers[rand(0, strlen($numbers) - 1)];

        return $letter . $number;
    }
}
