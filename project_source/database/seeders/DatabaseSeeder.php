<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Notification::factory(10)->create();
        NotificationRecipient::factory(10)->create();

//        $users = User::factory(10)->create();
//        $notifications = Notification::factory(10)->create();
//
//        foreach ($notifications as $notification) {
//            foreach ($users->random(3) as $user) { // Attach a few random users to each notification
//                NotificationRecipient::create([
//                    'noti_id' => $notification->id,
//                    'user_id' => $user->id,
//                ]);
//            }
//        }
    }
}
