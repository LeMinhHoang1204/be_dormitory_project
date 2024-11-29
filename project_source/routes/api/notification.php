<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index')->can('viewAny', \App\Models\Notification::class);

    Route::get('/notifications/create', [NotificationController::class, 'create'])->can('create', \App\Models\Notification::class);

    Route::post('/notifications/create', [NotificationController::class, 'store'])->name('notifications.store')->can('create', \App\Models\Notification::class);

    Route::get('/notifications/edit/{notification}', [NotificationController::class, 'edit'])->name('notifications.show')->can('update', 'notification');

    Route::post('/notifications/edit/{notification}', [NotificationController::class, 'update'])->name('notifications.edit')->can('update', 'notification');

    Route::delete('/notifications/delete/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy')->can('delete', 'notification');

});
