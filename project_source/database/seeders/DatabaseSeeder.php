<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\Residence;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'leminhhoang1204@gmail.com', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        // chuyen sang seeder
        Notification::factory(10)->create();
//        Student::factory(100)->create();
//        Building::factory(10)->create();
//        Room::factory(200)->create();
//        Residence::factory(100)->create();

        User::factory()->create([
            'name' => 'Châu Minh Trí',
            'email' => '22521515@gm.uit.edu.vn', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'building manager',
        ]);

        User::factory()->create([
            'name' => 'TuVi Building Manager A',
            'email' => '9a3tuthituongvi@gmail.com', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'building manager',
        ]);

        User::factory()->create([
            'name' => 'Lê Minh Hoàng',
            'email' => '22520464@gm.uit.edu.vn', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'student',
        ]);

        User::factory()->create([
            'name' => 'Võ Minh Vy',
            'email' => 'vyvominh@gmail.com', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);


        User::factory()->create([
            'name' => 'Từ Thị Tường Vi',
            'email' => '22521660@gm.uit.edu.vn', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Từ Thị Tường Vi',
            'email' => 'tuthituongvi9@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'accountant',
        ]);
        // Tạo một user với role là student
        User::create([
            'name' => 'Tường Vi',
            'email' => 'dovanhoang2004cpr@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'student',
        ]);

        $this->call([
            UserSeeder::class,
            StudentSeeder::class,
            EmployeeSeeder::class,
            BuildingSeeder::class,
            RoomSeeder::class,
            ResidenceSeeder::class,
//            AssetSeeder::class,
//            RoomAssetSeeder::class,
        ]);
    }
}
