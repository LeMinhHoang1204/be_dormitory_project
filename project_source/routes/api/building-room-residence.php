<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // buildings
    Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index')->can('viewAny', \App\Models\Building::class);

    Route::put('/buildings/update-manager/{building}', [BuildingController::class, 'updateManager'])->name('buildings.updateManager')->can('update', 'building');

    Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create')->can('create', \App\Models\Building::class);

    Route::post('/buildings/create', [BuildingController::class, 'store'])->name('buildings.store')->can('create', \App\Models\Building::class);

    Route::get('/buildings/{building}', [BuildingController::class, 'show'])->name('buildings.show')->can('view', 'building');

    Route::get('/buildings/edit/{building}', [BuildingController::class, 'edit'])->name('buildings.edit')->can('update', 'building');

    Route::post('/buildings/edit/{building}', [BuildingController::class, 'update'])->name('buildings.update')->can('update', 'building');

    Route::delete('/buildings/delete/{building}', [BuildingController::class, 'destroy'])->name('buildings.destroy')->can('delete', 'building');

    // rooms
    Route::prefix('/buildings/{building}/rooms')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('rooms.index')->can('viewAny', \App\Models\Room::class);

        Route::get('/create', [RoomController::class, 'create'])->name('rooms.create')->can('create', \App\Models\Room::class);

        Route::post('/create', [RoomController::class, 'store'])->name('rooms.store')->can('create', \App\Models\Room::class);

        Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('rooms.edit')->can('update', 'room');

        Route::post('/edit/{room}', [RoomController::class, 'update'])->name('rooms.update')->can('update', 'room');

        Route::delete('/delete/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy')->can('delete', 'room');
    });

    // residences
    Route::prefix('/buildings/{building}/rooms/{room}/residences')->group(function () {
        Route::get('/', [ResidenceController::class, 'index'])->name('residences.index')->can('viewAny', \App\Models\Residence::class);

        Route::get('/create', [ResidenceController::class, 'create'])->name('residences.create')->can('create', \App\Models\Residence::class);

        Route::post('/register', [ResidenceController::class, 'store'])->name('residences.store')->can('create', \App\Models\Residence::class);

        Route::get('/register', [ResidenceController::class, 'create'])->name('residences.create')->can('create', \App\Models\Residence::class);

        Route::post('/register', [ResidenceController::class, 'store'])->name('residences.store')->can('create', \App\Models\Residence::class);

        Route::get('/edit/{residence}', [ResidenceController::class, 'edit'])->name('residences.edit')->can('update', 'residence');

        Route::post('/edit/{residence}', [ResidenceController::class, 'update'])->name('residences.update')->can('update', 'residence');

        Route::delete('/delete/{residence}', [ResidenceController::class, 'destroy'])->name('residences.destroy')->can('delete', 'residence');
    });
});