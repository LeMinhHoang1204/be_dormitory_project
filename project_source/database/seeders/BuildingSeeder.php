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
        // Tạo 20 toà mỗi toà 20 tầng, 200 phòng
        // Tạo 10 tòa cho nam
        for ($i = 1; $i <= 10; $i++) {
            Building::create([
                'build_name' => 'A' . $i,
                'type' => 'male',
                'floor_numbers' => 20,
                'room_numbers' => 200,
            ]);
        }

        // Tạo 10 tòa cho nữ
        for ($i = 1; $i <= 10; $i++) {
            Building::create([
                'build_name' => 'B' . $i,
                'type' => 'female',
                'floor_numbers' => 20,
                'room_numbers' => 200,
            ]);
        }
    }

    private function generateRandomBuildingName(): string
    {
        $letters = 'AB';
        $numbers = '123456789';

        $letter = $letters[rand(0, strlen($letters) - 1)];

        $number = $numbers[rand(0, strlen($numbers) - 1)];

        return $letter . $number;
    }
}
