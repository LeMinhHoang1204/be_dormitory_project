<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {


    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');


    // notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index')->can('viewAny', \App\Models\Notification::class);

    Route::get('/notifications/create', [NotificationController::class, 'create'])->can('create', \App\Models\Notification::class);

    Route::post('/notifications/create', [NotificationController::class, 'store'])->name('notifications.store')->can('create', \App\Models\Notification::class);

    Route::get('/notifications/edit/{notification}', [NotificationController::class, 'edit'])->name('notifications.show')->can('update', 'notification');

    Route::post('/notifications/edit/{notification}', [NotificationController::class, 'update'])->name('notifications.edit')->can('update', 'notification');

    Route::delete('/notifications/delete/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy')->can('delete', 'notification');

    // buildings
    Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index')->can('viewAny', \App\Models\Building::class);

    Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create')->can('create', \App\Models\Building::class);

    Route::post('/buildings/create', [BuildingController::class, 'store'])->name('buildings.store')->can('create', \App\Models\Building::class);

    Route::get('/buildings/edit/{building}', [BuildingController::class, 'edit'])->name('buildings.show')->can('update', 'building');

    Route::post('/buildings/edit/{building}', [BuildingController::class, 'update'])->name('buildings.edit')->can('update', 'building');

    Route::delete('/buildings/delete/{building}', [BuildingController::class, 'destroy'])->name('buildings.destroy')->can('delete', 'building');

    // rooms
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index')->can('viewAny', \App\Models\Room::class);

    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create')->can('create', \App\Models\Room::class);

    Route::post('/rooms/create', [RoomController::class, 'store'])->name('rooms.store')->can('create', \App\Models\Room::class);

    Route::get('/rooms/edit/{building}', [RoomController::class, 'edit'])->name('rooms.show')->can('update', 'room');

    Route::post('/rooms/edit/{building}', [RoomController::class, 'update'])->name('rooms.edit')->can('update', 'room');

    Route::delete('/rooms/delete/{building}', [RoomController::class, 'destroy'])->name('rooms.destroy')->can('delete', 'room');
});

