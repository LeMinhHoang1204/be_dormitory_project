<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Notification;
use App\Models\RegistrationActivity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationRecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = Notification::All();

        $notifications->each(function ($notification) {
            $reader_count = $notification->reader_count;
            $users = User::where('role', 'student')->inRandomOrder()->limit($reader_count)->get();
            for ($i = 1; $i <= $reader_count; $i++) {
                RegistrationActivity::factory()->state([
                    'user_id' => $users[$i - 1]->id,
                    'noti_id' => $notification->id,
                ])->create();
            }
        });
    }
}
