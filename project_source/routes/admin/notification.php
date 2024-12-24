<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index')->can('viewAny', \App\Models\Notification::class);

    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create')->can('create', \App\Models\Notification::class);

    Route::post('/notifications/create', [NotificationController::class, 'store'])->name('notifications.store')->can('create', \App\Models\Notification::class);

    Route::get('/notifications/edit/{notification}', [NotificationController::class, 'edit'])->name('notifications.show')->can('update', 'notification');

    Route::post('/notifications/edit/{notification}', [NotificationController::class, 'update'])->name('notifications.edit')->can('update', 'notification');

    Route::delete('/notifications/delete/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy')->can('delete', 'notification');

    Route::get('/admin/getAllBuildings', [NotificationController::class, 'getAllBuilding'])->name('notifications.getAllBuilding')->can('create', \App\Models\Notification::class);;

    Route::get('/admin/getAllRooms/{building_id}', [NotificationController::class, 'getAllRoom'])->name('notifications.getAllRoom')->can('create', \App\Models\Notification::class);;

    Route::get('/admin/getAllUsers', [NotificationController::class, 'getAllUser'])->name('notifications.getAllUser')->can('create', \App\Models\Notification::class);;

    Route::get('/get-users-by-room/{roomId}', [NotificationController::class, 'getUsersByRoom'])
        ->name('notifications.getUsersByRoom')
        ->middleware('auth');
});
