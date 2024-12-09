<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Student::truncate();
        // Lấy tất cả các User có role là 'student'
        $users = User::where('role', 'student')->get();

        // Tạo Student cho mỗi User
//        $users->each(function ($user) {
//            Student::factory()->state([
//                'user_id' => $user->id, // Gán user_id từ User hiện tại
//            ])->create();
//        });
//
//        TODO: GÁN USER-STUDENT LÀ STUDENT (LẤY ĐÚNG TÊN) (DONE)
        $users->each(function ($user) {
            $uniId = rand(1000, 9999);
            Student::create([
                'user_id' => $user->id,
                'uni_name' => Arr::random(['DHQGHN', 'DHQGTPHCM', 'BKHN','BKHCM','KTQD','FTU','UEH', 'YHN','YTPHCM']),
                // (không gán thì tên student tạo lại ngẫu nhiên chứ ko lấy tên từ user, không phân biệt được)

                'uni_id' => $uniId,
                'dob' => now(),
                'gender' => Arr::random(['male', 'female']),
//                'room_id' => 1,
            ]);
        });
    }
}
