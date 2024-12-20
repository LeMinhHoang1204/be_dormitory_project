<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create(['role' => 'building manager']);
        User::factory(3800)->create(['role' => 'student']);
//        User::factory(2)->create(['role' => 'accountant']);
    }
}
