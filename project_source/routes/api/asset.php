<?php

use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // assets
    Route::prefix('/assets')->group(function () {
        Route::get('/', [AssetController::class, 'index'])->name('assets.index')->can('viewAny', \App\Models\Asset::class);

        Route::get('/create', [AssetController::class, 'create'])->name('assets.create')->can('create', \App\Models\Asset::class);

        Route::post('/create', [AssetController::class, 'store'])->name('assets.store')->can('create', \App\Models\Asset::class);

        Route::get('/edit/{asset}', [AssetController::class, 'edit'])->name('assets.edit')->can('update', \App\Models\Asset::class);

        Route::post('/edit/{asset}', [AssetController::class, 'update'])->name('assets.update')->can('update', \App\Models\Asset::class);

        Route::delete('/delete/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy')->can('delete', \App\Models\Asset::class);
    });

    Route::prefix('/buildings/{building}/rooms/{room}/assets')->group(function () {
        Route::get('/create', [AssetController::class, 'create'])->name('assets.create')->can('create', \App\Models\RoomAsset::class);

        Route::post('/create', [AssetController::class, 'store'])->name('assets.store')->can('create', \App\Models\RoomAsset::class);

        Route::delete('/delete/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy')->can('delete', \App\Models\RoomAsset::class);
    });

});
