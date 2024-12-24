<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // buildings
    Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index')->can('viewAny', \App\Models\Building::class);

    Route::put('/buildings/update-manager/{building}', [BuildingController::class, 'updateManager'])->name('buildings.updateManager')->can('update', \App\Models\Building::class);

    Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create')->can('create', \App\Models\Building::class);

    Route::post('/buildings/create', [BuildingController::class, 'store'])->name('buildings.store')->can('create', \App\Models\Building::class);
    Route::post('/buildings/{building}', [BuildingController::class, 'update'])->name('buildings.update');

//    Route::get('/buildings/{building}', [BuildingController::class, 'show'])->name('buildings.show')->can('view', \App\Models\Building::class);
    Route::get('/buildings/show/{building}', [BuildingController::class, 'show'])
        ->name('buildings.show')
        ->middleware('can:view,building');

//    Route::get('/buildings/edit/{building}', [BuildingController::class, 'edit'])->name('buildings.edit')->can('update', \App\Models\Building::class);

    Route::get('/buildings/edit/{building}', [BuildingController::class, 'edit'])
        ->name('buildings.edit')
        ->middleware('can:update,building');

//    Route::delete('/buildings/delete/{building}', [BuildingController::class, 'destroy'])->name('buildings.destroy')->can('delete', \App\Models\Building::class);
    Route::delete('/buildings/delete/{building}', [BuildingController::class, 'destroy'])
        ->name('buildings.destroy')
        ->middleware('can:delete,building');

    Route::get('building-manager/buildings/{building}', [BuildingController::class, 'showBuildingDetails'])->middleware('auth')->name('mybuilding.show');

    Route::get('student/{studentId}/profile/{roomId}', [BuildingController::class, 'showProfile'])
        ->middleware(['auth', 'role:admin,building manager'])
        ->name('student.profile');
    // rooms
    Route::prefix('/buildings/{building}/rooms')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('rooms.index')->can('viewAny', \App\Models\Room::class);

        Route::get('/create', [RoomController::class, 'create'])->name('rooms.create')->can('create', \App\Models\Room::class);

        Route::post('/create', [RoomController::class, 'store'])
            ->name('rooms.store')
            ->can('create', \App\Models\Room::class);

        Route::get('/{room}', [RoomController::class, 'show'])->name('rooms.show')->can('view', 'room');

        Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('rooms.edit')->can('update', 'room');

        Route::put('/edit/{room}', [RoomController::class, 'update'])->name('rooms.update')->can('update', 'room');

        Route::delete('/delete/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    });

    // residences
    Route::prefix('/buildings/{building}/rooms/{room}/residences')->group(function () {
        Route::get('/', [ResidenceController::class, 'index'])->name('residences.index')->can('viewAny', \App\Models\Residence::class);

        Route::get('/create', [ResidenceController::class, 'create'])->name('residences.create')->can('create', \App\Models\Residence::class);

        Route::post('/register', [ResidenceController::class, 'store'])->name('residences.store')->can('create', \App\Models\Residence::class);

        Route::get('/register', [ResidenceController::class, 'create'])->name('residences.create')->can('create', \App\Models\Residence::class);

        Route::post('/register', [ResidenceController::class, 'store'])->name('residences.store')->can('create', \App\Models\Residence::class);

        Route::get('/edit/{residence}', [ResidenceController::class, 'edit'])->name('residences.edit')->can('update', \App\Models\Residence::class);

        Route::post('/edit/{residence}', [ResidenceController::class, 'update'])->name('residences.update')->can('update', \App\Models\Residence::class);

        Route::delete('/delete/{residence}', [ResidenceController::class, 'destroy'])->name('residences.destroy')->can('delete', \App\Models\Residence::class);
    });


});
