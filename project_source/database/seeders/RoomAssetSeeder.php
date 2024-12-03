<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = \App\Models\Room::All();
        $assets = \App\Models\Asset::All();

       $rooms->each(function ($room) use ($assets) {
            $assets->random(rand(1, $assets->count()))->each(function ($asset) use ($room) {
                \App\Models\RoomAsset::factory()->state([
                    'room_id' => $room->id,
                    'asset_id' => $asset->id,
                ])->create();
            });
       });
    }
}
