<?php

namespace Database\Seeders;

use App\Models\RegistrationActivity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

        User::factory()->create([
            'name' => 'Châu Minh Trí',
            'email' => '22521515@gm.uit.edu.vn', // Set a known email
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
            'name' => 'Lê Minh Hoàng Kế Toán',
            'email' => 'hoangminhle1204@gmail.com', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'accountant',
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

        $this->call([
            UserSeeder::class,
            StudentSeeder::class,
            EmployeeSeeder::class,
            BuildingSeeder::class,
            RoomSeeder::class,
            ResidenceSeeder::class,
            NotificationSeeder::class,
//            NotificationRecipientSeeder::class,
            AssetSeeder::class,
            RoomAssetSeeder::class,
            InvoiceSeeder::class,
            RequestSeeder::class,
            ActivitySeeder::class,
            RegistrationActivitySeeder::class,
            ViolationSeeder::class,
        ]);
    }
}