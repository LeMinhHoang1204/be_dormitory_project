<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả các User có role là 'student'
        $users = User::where('role', 'student')->get();

        // Tạo Student cho mỗi User
        $users->each(function ($user) {
            Student::factory()->state([
                'user_id' => $user->id, // Gán user_id từ User hiện tại
            ])->create();
        });
    }
}
