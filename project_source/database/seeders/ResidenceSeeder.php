<?php

namespace Database\Seeders;
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

//        \App\Models\Student::limit(50)->get()->each(function ($student) {
//            \App\Models\Residence::factory()->state(['stu_id' => $student->id])->create();
//        });

        $students = Student::orderBy('id', 'asc')->limit(300)->get();

        // Lấy tất cả phòng có sẵn
        $rooms = Room::pluck('id')->toArray();

        $students->each(function ($student) use ($rooms) {
            $duration = Arr::random(['3 months', '6 months', '9 months', '12 months']); // Giá trị duration ngẫu nhiên
            $status = Arr::random(['Registered', 'Paid', 'Checked in', 'Transfered', 'Checked out']); // Giá trị status ngẫu nhiên
            $start_date = Carbon::now(); // Ngày bắt đầu
            $end_date = (clone $start_date)->addMonths((int) filter_var($duration, FILTER_SANITIZE_NUMBER_INT)); // Tính end_date

            Residence::create([
                'stu_user_id' => $student->id,
                'room_id' => Arr::random($rooms),
                'start_date' => $start_date,
                'duration' => $duration,
                'end_date' => $end_date,
                'check_out_date' => null,
                'status' => $status,
                'note' => null,
            ]);
        });
    }
}
