<?php

namespace Database\Seeders;
use App\Models\Building;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\Residence;
use App\Models\Room;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash; // Import Hash

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả sinh viên nam ngoại trừ sinh viên có id = 3
        $students = Student::where('user_id', '!=', 3)->where('gender', 'male')->orderBy('id', 'asc')->limit(2000)->get();

        // Lấy tất cả tòa nam có sẵn
        $maleBuildings = Building::where('type', 'male')->with('hasRooms')->get();
        $studentIndex = 0;

        foreach ($maleBuildings as $building) {
            foreach ($building->hasRooms as $room) {
                for ($i = 0; $i < $room->type; $i++) {
                    if ($studentIndex >= $students->count()) {
                        break;
                    }

                    $student = $students[$studentIndex];
                    $studentIndex++;

                    $months_duration = Arr::random([3, 6, 9, 12]); // Random duration value
                    $status = 'Checked in'; // Set status to 'Checked in'
                    $start_date = Carbon::create(2024, 9, 1); // Start date from January 2023
                    $end_date = (clone $start_date)->addMonths((int) filter_var($months_duration, FILTER_SANITIZE_NUMBER_INT)); // Calculate end_date

                    $residence = Residence::create([
                        'stu_user_id' => $student->user_id,
                        'room_id' => $room->id,
                        'start_date' => $start_date,
                        'months_duration' => $months_duration,
                        'end_date' => $end_date,
                        'check_out_date' => null,
                        'status' => $status,
                        'note' => null,
                    ]);

                    // Create a paid room registration invoice
                    Invoice::create([
                        'sender_id' => 1,
                        'object_id' => $student->user_id,
                        'object_type' => 'App\Models\User',
                        'start_date' => $start_date,
                        'send_date' => $start_date,
                        'due_date' => $start_date->addDays(7),
                        'paid_date' => $start_date,
                        'type' => 'Room Registration',
                        'status' => 'Paid',
                        'total' => $room->unit_price * $months_duration,
                        'payment_method' => rand(1, 2) === 1 ? 'Cash' : 'Bank transfer',
                        'note' => 'Room registration',
                    ]);
                }

                // Create monthly invoices from January 2023 to the present
                $currentDate = Carbon::create(2023, 1, 1);
                $now = Carbon::now();
                while ($currentDate->lessThanOrEqualTo($now)) {
                    foreach (['Electricity', 'Water', 'Cleaning'] as $type) {
                        Invoice::create([
                            'sender_id' => 1,
                            'object_id' => $room->id,
                            'object_type' => 'App\Models\Room',
                            'type' => $type,
                            'status' => 'Paid',
                            'send_date' => $currentDate,
                            'due_date' => $currentDate->addDays(7),
                            'paid_date' => $currentDate,
                            'total' => rand(5, 10) * 100000,
                            'payment_method' => rand(1, 2) === 1 ? 'Cash' : 'Bank transfer',
                            'note' => $type . ' invoice for ' . $currentDate->format('F Y'),
                        ]);
                    }
                    $currentDate->addMonth();
                }
            }
        }

        // Lấy tất cả sinh viên nu ngoại trừ sinh viên có id = 3
        $students = Student::where('user_id', '!=', 3)->where('gender', 'female')->orderBy('id', 'asc')->limit(2000)->get();

        // Lấy tất cả tòa nam có sẵn
        $femaleBuildings = Building::where('type', 'female')->with('hasRooms')->get();
        $femaleStudentIndex = 0;

        foreach ($femaleBuildings as $building) {
            foreach ($building->hasRooms as $room) {
                for ($i = 0; $i < $room->type; $i++) {
                    if ($femaleStudentIndex >= $students->count()) {
                        break;
                    }

                    $student = $students[$femaleStudentIndex];
                    $femaleStudentIndex++;

                    $months_duration = Arr::random([3, 6, 9, 12]); // Random duration value
                    $status = 'Checked in'; // Set status to 'Checked in'
                    $start_date = Carbon::create(2024, 9, 1); // Start date from January 2023
                    $end_date = (clone $start_date)->addMonths((int) filter_var($months_duration, FILTER_SANITIZE_NUMBER_INT)); // Calculate end_date

                    $residence = Residence::create([
                        'stu_user_id' => $student->user_id,
                        'room_id' => $room->id,
                        'start_date' => $start_date,
                        'months_duration' => $months_duration,
                        'end_date' => $end_date,
                        'check_out_date' => null,
                        'status' => $status,
                        'note' => null,
                    ]);

                    // Create a paid room registration invoice
                    Invoice::create([
                        'sender_id' => 1,
                        'object_id' => $student->user_id,
                        'object_type' => 'App\Models\User',
                        'start_date' => $start_date,
                        'send_date' => $start_date,
                        'due_date' => $start_date->addDays(7),
                        'paid_date' => $start_date,
                        'type' => 'Room Registration',
                        'status' => 'Paid',
                        'total' => $room->unit_price * $months_duration,
                        'payment_method' => rand(1, 2) === 1 ? 'Cash' : 'Bank transfer',
                        'note' => 'Room registration',
                    ]);
                }

                // Create monthly invoices from January 2023 to the present
                $currentDate = Carbon::create(2023, 1, 1);
                $now = Carbon::now();
                while ($currentDate->lessThanOrEqualTo($now)) {
                    foreach (['Electricity', 'Water', 'Cleaning'] as $type) {
                        Invoice::create([
                            'sender_id' => 1,
                            'object_id' => $room->id,
                            'object_type' => 'App\Models\Room',
                            'type' => $type,
                            'status' => 'Paid',
                            'send_date' => $currentDate,
                            'due_date' => $currentDate->addDays(7),
                            'paid_date' => $currentDate,
                            'total' => rand(5, 10) * 100000,
                            'payment_method' => rand(1, 2) === 1 ? 'Cash' : 'Bank transfer',
                            'note' => $type . ' invoice for ' . $currentDate->format('F Y'),
                        ]);
                    }
                    $currentDate->addMonth();
                }
            }
        }

    }
}
