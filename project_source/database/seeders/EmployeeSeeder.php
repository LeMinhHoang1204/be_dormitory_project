<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả User có vai trò là 'building manager' hoặc 'accountant'
        $users = User::whereIn('role', ['building manager', 'accountant'])->get();

        // Duyệt qua từng User và tạo một Employee cho mỗi User
        $users->each(function ($user) {
            Employee::factory()->state([
                'user_id' => $user->id,
                'manager_id' => User::where('role', 'admin')->inRandomOrder()->first()->id ?? null, // Lấy admin ngẫu nhiên làm manager
                'type' => $user->role, // Đặt type theo role của User
            ])->create();
        });
    }
}
