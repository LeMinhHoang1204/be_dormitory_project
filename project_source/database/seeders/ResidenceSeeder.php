<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Student::limit(50)->get()->each(function ($student) {
            \App\Models\Residence::factory()->state(['stu_id' => $student->id])->create();
        });
    }
}
