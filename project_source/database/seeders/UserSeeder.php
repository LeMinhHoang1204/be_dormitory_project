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

//    public function run(): void
//    {
//        for ($i = 0; $i < 10; $i++) {
//            DB::table('users')->insert([
//                'name' => Str::random(10),
//                'email' => Str::random(10) . '@example.com',
//                'password' => Hash::make('password'),
//            ]);
//        }
//    }


    public function run(): void
    {
        User::factory(10)->create();
    }

}
