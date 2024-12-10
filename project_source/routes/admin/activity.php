<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RegistrationActivityController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // activities
    Route::prefix('/activities')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('activities.index')->can('viewAny', \App\Models\Activity::class);

        Route::get('/create', [ActivityController::class, 'create'])->name('activities.create')->can('create', \App\Models\Activity::class);

        Route::post('/create', [ActivityController::class, 'store'])->name('activities.store')->can('create', \App\Models\Activity::class);

        Route::get('/{activity}', [ActivityController::class, 'show'])->name('activities.show')->can('view', \App\Models\Activity::class);

        Route::get('/edit/{activity}', [ActivityController::class, 'edit'])->name('activities.edit')->can('update', \App\Models\Activity::class);

        Route::post('/edit/{activity}', [ActivityController::class, 'update'])->name('activities.update')->can('update', \App\Models\Activity::class);

        Route::delete('/delete/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy')->can('delete', \App\Models\Activity::class);
    });

    Route::prefix('/activities/{activity}/registrationActivities')->group(function () {
        Route::get('/register', [RegistrationActivityController::class, 'create'])->name('activities.create')->can('create', \App\Models\RegistrationActivity::class);

        Route::post('/register', [RegistrationActivityController::class, 'store'])->name('activities.store')->can('create', \App\Models\RegistrationActivity::class);

        Route::get('/edit/{registrationActivity}', [RegistrationActivityController::class, 'edit'])->name('activities.edit')->can('update', \App\Models\RegistrationActivity::class);

        Route::post('/edit/{registrationActivity}', [RegistrationActivityController::class, 'update'])->name('activities.update')->can('update', \App\Models\RegistrationActivity::class);

        Route::delete('/delete/{registrationActivity}', [RegistrationActivityController::class, 'destroy'])->name('activities.destroy')->can('delete', \App\Models\RegistrationActivity::class);
    });

});
