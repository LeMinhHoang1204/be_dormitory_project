<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Residence;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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
        // admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'leminhhoang1204@gmail.com', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        // building manager
        User::factory()->create([
            'name' => 'Châu Minh Trí',
            'email' => '22521515@gm.uit.edu.vn', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'building manager',
        ]);

        // student
        User::factory()->create([
            'name' => 'Lê Minh Hoàng',
            'email' => '22520464@gm.uit.edu.vn', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'student',
        ]);

        // accountant
        User::factory()->create([
            'name' => 'Kế Toán Minh Hoàng',
            'email' => 'hoangminhle1204@gmail.com', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'accountant',
        ]);

        User::factory()->create([
            'name' => 'Nam Nguyen',
            'email' => '22521516@gm.uit.edu.vn', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'building manager',
        ]);

        // user 6 for testing transfer
        // user 6 for testing transfer
        User::factory()->create([
            'name' => 'Lê Minh Trí',
            'email' => '22520465@gm.uit.edu.vn', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'student',
        ]);

        // user 7
        User::factory()->create([
            'name' => 'Lê Minh Vy',
            'email' => '22520466@gm.uit.edu.vn', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'student',
        ]);

        // user 8
        User::factory()->create([
            'name' => 'Lê Minh Vi',
            'email' => '22520467@gm.uit.edu.vn', // Set a known email
            'password' => Hash::make('12345678'), // Use a secure password
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
            NotificationSeeder::class,
//            NotificationRecipientSeeder::class,
            AssetSeeder::class,
            RoomAssetSeeder::class,
            InvoiceSeeder::class,
            RequestSeeder::class,
            ActivitySeeder::class,
            RegistrationActivitySeeder::class,
            ViolationSeeder::class,
            ComplaintViolationSeeder::class,
        ]);

        // test request
//        Residence::create([
//            'stu_user_id' => 3,
//            'room_id' => 1,
//            'start_date' => Carbon::create(2024, 9, 1),
//            'months_duration' => 6,
//            'end_date' => Carbon::create(2024, 9, 1)->addMonths(6),
//            'check_out_date' => null,
//            'status' => 'Checked in',
//            'note' => 'Residence test',
//        ]);
//
//        Invoice::create([
//            'sender_id' => 1,
//            'object_id' => 3,
//            'object_type' => 'App\Models\User',
//            'start_date' => Carbon::create(2024, 9, 1),
//            'send_date' => Carbon::create(2024, 9, 1),
//            'due_date' => Carbon::create(2024, 9, 1)->addDays(7),
//            'paid_date' => Carbon::create(2024, 9, 1)->addDays(3),
//            'type' => 'Room Registration',
//            'status' => 'Paid',
//            'total' => 1000000 * 6,
//            'payment_method' => rand(1, 2) === 1 ? 'Cash' : 'Bank transfer',
//            'note' => 'Invoice test',
//        ]);

    }
}
