<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\ComplaintViolation;

class ComplaintViolationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        ComplaintViolation::factory(30)->create();
    }
}
