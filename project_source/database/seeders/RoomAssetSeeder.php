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
            // Assign other assets based on room type
            $assetNames = ['table', 'chair', 'bed', 'fan'];
            foreach ($assetNames as $name) {
                $asset = $assets->firstWhere('name', $name);
                \App\Models\RoomAsset::factory()->state([
                    'room_id' => $room->id,
                    'asset_id' => $asset->id,
                    'quantity' => $room->type,
                ])->create();
            }

            // Assign specific assets based on room type
            $specialAssets = ['air conditioner', 'television', 'water heater', 'toilet'];
            foreach ($specialAssets as $name) {
                $asset = $assets->firstWhere('name', $name);
                \App\Models\RoomAsset::factory()->state([
                    'room_id' => $room->id,
                    'asset_id' => $asset->id,
                    'quantity' => $room->type === 2 || $room->type === 4 ? 1 : 2,
                ])->create();
            }
        });
    }
}
