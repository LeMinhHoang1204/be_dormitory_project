<?php


use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // building manager check in requests
    Route::prefix('/admin/buildings')->group(function () {

        Route::get('/', [BuildingController::class, 'index'])->name('buildings.index')->can('viewAny', \App\Models\Building::class);

        Route::put('/update-manager/{building}', [BuildingController::class, 'updateManager'])->name('buildings.updateManager')->can('update', \App\Models\Building::class);

        Route::get('/create', [BuildingController::class, 'create'])->name('buildings.create')->can('create', \App\Models\Building::class);

        Route::post('/create', [BuildingController::class, 'store'])->name('buildings.store')->can('create', \App\Models\Building::class);
        Route::post('/{building}', [BuildingController::class, 'update'])->name('buildings.update');

//    Route::get('/{building}', [BuildingController::class, 'show'])->name('buildings.show')->can('view', \App\Models\Building::class);
        Route::get('/show/{building}', [BuildingController::class, 'show'])
            ->name('buildings.show')
            ->middleware('can:view,building');

//    Route::get('/edit/{building}', [BuildingController::class, 'edit'])->name('buildings.edit')->can('update', \App\Models\Building::class);

        Route::get('/edit/{building}', [BuildingController::class, 'edit'])
            ->name('buildings.edit')
            ->middleware('can:update,building');

//    Route::delete('/delete/{building}', [BuildingController::class, 'destroy'])->name('buildings.destroy')->can('delete', \App\Models\Building::class);
        Route::delete('/delete/{building}', [BuildingController::class, 'destroy'])
            ->name('buildings.destroy')
            ->middleware('can:delete,building');
    });


    // rooms
    Route::prefix('/admin/buildings/{building}/rooms')->group(function () {
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

    // requests
    Route::prefix('/admin/requests')->group(function () {

        Route::get('/', [RequestController::class, 'index'])->name('requests.index')->can('viewAny', \App\Models\Request::class);

        Route::get('/{request}', [RequestController::class, 'show'])->name('requests.show')->can('view', 'request');

        Route::delete('/delete/{request}', [RequestController::class, 'destroy'])->name('requests.destroy')->can('delete', 'request');

        Route::post('/accept/{request}', [RequestController::class, 'accept'])->name('requests.accept')->can('confirmRequest', 'request');

        Route::post('/reject/{request}', [RequestController::class, 'reject'])->name('requests.reject')->can('confirmRequest', 'request');

        Route::post('/resolve/{request}', [RequestController::class, 'resolve'])->name('requests.resolve')->can('resolveRequest', 'request');

    });
});
