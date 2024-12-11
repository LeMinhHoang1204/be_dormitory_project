<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RegistrationActivityController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('activities', ActivityController::class);

    // Route nhóm dành cho quản trị viên
    Route::get('/admin/activities', [ActivityController::class, 'adminIndex'])->name('admin.activities.index');
    Route::get('/admin/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/admin/activities', [ActivityController::class, 'store'])->name('activities.store');
    // Hiển thị chi tiết hoạt động
    Route::get('/admin/activities/{id}', [ActivityController::class, 'show'])->name('admin_activities.show');

    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    // Sửa hoạt động
    Route::get('/admin/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
//    Route::put('/admin/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
//    Route::put('activities/{activity}', function ($id) {
//        dd($id);
//    });
    Route::delete('/admin/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    Route::get('/admin/my-activities', [ActivityController::class, 'myActivities'])->name('my.activities')->middleware('auth');

// Route nhóm dành cho sinh viên
    // Hiển thị danh sách hoạt động (student view)
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');

    // Hiển thị chi tiết hoạt động (student view)
    Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.show');
    Route::get('/my-activities', [RegistrationActivityController::class, 'myActivities'])->name('my.activities')->middleware('auth');

//    Route::get('/activities/{activity}/participants', [ActivityController::class, 'participants'])
//        ->name('activities.participants')
//        ->middleware('auth');});
//
    Route::get('/activity/{activity}/participants', [ActivityController::class, 'participants'])
        ->name('activity.participants');
});

Route::prefix('/activities/{activity}/registrationActivities')->group(function () {
    Route::post('/register', [RegistrationActivityController::class, 'store'])->name('student_activities.register');

    Route::delete('/cancel', [RegistrationActivityController::class, 'destroy'])->name('activities.cancel');
});
