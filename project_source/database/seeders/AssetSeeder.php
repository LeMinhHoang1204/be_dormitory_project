<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['air conditioner', 'table', 'chair', 'bed', 'fridge', 'fan', 'television', 'water heater', 'toilet'];

        foreach ($names as $name) {
            \App\Models\Asset::factory()->state(['name' => $name])->create();
        }
    }
}
