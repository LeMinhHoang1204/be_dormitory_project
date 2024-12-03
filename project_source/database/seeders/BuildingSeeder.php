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
        Building::factory(5)->create();

//        $buildingNames = ['A', 'B'];

        $users = Employee::whereIn('user_id', [
            User::where('email', '22521515@gm.uit.edu.vn')->first()->id,
            User::where('email', '9a3tuthituongvi@gmail.com')->first()->id
        ])->get();

        // Kiểm tra nếu tìm thấy đủ người quản lý
        if ($users->count() < 2) {
            throw new \Exception('Users with specified emails not found!');
        }

        // Tạo các tòa nhà với thông tin tòa nhà và quản lý
        $buildings = [
            ['type' => 'male', 'floor_numbers' => 5, 'room_numbers' => 50, 'manager' => $users[0]],
            ['type' => 'female', 'floor_numbers' => 4, 'room_numbers' => 40, 'manager' => $users[1]],
        ];

        foreach ($buildings as $building) {
            Building::create([
                'type' => $building['type'],
                'floor_numbers' => $building['floor_numbers'],
                'room_numbers' => $building['room_numbers'],
                'student_count' => 0,
                'manager_id' => $building['manager']->id, // Gán quản lý cho từng tòa
            ]);
        }
    }
}
