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
//            for ($i = 1; $i <= $floorNumbers; $i++) {
//                for ($j = 1; $j <= $roomNumbers / $floorNumbers; $j++) {
//                    Room::factory()->state([
//                        'floor_number' => $i,
//                        'building_id' => $building->id,
//                    ])->create();
//                }
//            }
//            / Tạo phòng cho mỗi tầng trong tòa nhà
            for ($i = 1; $i <= $floorNumbers; $i++) {
                $roomsPerFloor = $roomNumbers / $floorNumbers;

                // Tạo từng phòng trên mỗi tầng
                for ($j = 1; $j <= $roomsPerFloor; $j++) {
                    // Tạo số phòng (phòng 1 là 01, phòng 2 là 02,...)
                    $roomNumber = str_pad($j, 2, '0', STR_PAD_LEFT);

                    // Tạo tên phòng theo quy tắc: Tên tòa (ví dụ A5) + số tầng + số thứ tự phòng
                    $floorNumber = $i < 10 ? $i : str_pad($i, 2, '0', STR_PAD_LEFT); // Chỉ thêm số 0 nếu tầng >= 10
                    $roomName = $building->build_name . '.' . $floorNumber . $roomNumber;
                    $unitPrice = rand(5, 30) * 100000;
                    Room::create([
                        'name' => $roomName,
                        'floor_number' => $i,
                        'building_id' => $building->id,
                        'type' => ['2', '4', '6', '8', '10'][array_rand(['2', '4', '6', '8', '10'])],
                        'unit_price' => $unitPrice,
                        'status' => 1,
                    ]);
                }
            }
        });
    }
}
