<?php

namespace Database\Seeders;

use App\Models\Violation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ViolationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Violation::factory(30)->create();
    }
}
