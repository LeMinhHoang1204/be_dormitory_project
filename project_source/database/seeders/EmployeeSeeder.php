<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả User có vai trò là 'building manager' hoặc 'accountant'
        $users = User::whereIn('role', ['building manager'])->get();

        // Duyệt qua từng User và tạo một Employee cho mỗi User
//        $users->each(function ($user) {
//            Employee::factory()->state([
//                'user_id' => $user->id,
//                'manager_id' => User::where('role', 'admin')->inRandomOrder()->first()->id ?? null, // Lấy admin ngẫu nhiên làm manager
//                'type' => $user->role, // Đặt type theo role của User
//            ])->create();
//        });

        //        TODO:  (DONE)
        $users->each(function ($user) {
            $unicitiId = rand(1000, 9999);
            Employee::create([
                'user_id' => $user->id,
                'emp_name' => $user->name,
                // (không gán thì tên nhân viên tạo lại ngẫu nhiên chứ ko lấy tên từ user, không phân biệt được)
                'citizen_id' => $unicitiId, // Gán ngẫu nhiên
                'manager_id' => User::where('role', 'admin')->inRandomOrder()->first()->id ?? null,
                'type' => $user->role,
                'dob' => now(),
                'gender' => Arr::random(['male', 'female']),
//                'room_id' => 1,
            ]);
        });
        //            $admins = User::where('role', 'admin')->get();
//            foreach ($admins as $admin) {
//                // Gán admin làm manager cho employee thông qua admin_employee
//                $employee->admins()->attach($admin->id);
//            }
    }
}
