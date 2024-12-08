<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RegistrationActivityController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('activities', ActivityController::class);

    // Route nhóm dành cho quản trị viên
    Route::get('/admin/activities', [ActivityController::class, 'adminIndex'])->name('admin.activities.index');

    // Tạo mới hoạt động
    Route::get('/admin/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/admin/activities', [ActivityController::class, 'store'])->name('activities.store');

    // Hiển thị chi tiết hoạt động
    Route::get('/admin/activities/{id}', [ActivityController::class, 'show'])->name('admin_activities.show');

    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    // Sửa hoạt động
    Route::get('/admin/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
//    Route::put('/admin/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
//    Route::put('activities/{activity}', function ($id) {
//        dd($id); // Kiểm tra xem ID có đúng không khi gửi form
//    });

    // Xóa hoạt động
    Route::delete('/admin/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

// Route nhóm dành cho sinh viên
        // Hiển thị danh sách hoạt động (student view)
        Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');

        // Hiển thị chi tiết hoạt động (student view)
        Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.show');
    });




//    Route::prefix('/activities/{activity}/registrationActivities')->group(function () {
//        Route::get('/register', [RegistrationActivityController::class, 'create'])->name('activities.create')->can('create', \App\Models\RegistrationActivity::class);

//        Route::post('/register', [RegistrationActivityController::class, 'store'])->name('activities.store')->can('create', \App\Models\RegistrationActivity::class);

//        Route::get('/edit/{registrationActivity}', [RegistrationActivityController::class, 'edit'])->name('activities.edit')->can('update', \App\Models\RegistrationActivity::class);

//        Route::post('/edit/{registrationActivity}', [RegistrationActivityController::class, 'update'])->name('activities.update')->can('update', \App\Models\RegistrationActivity::class);

//        Route::delete('/delete/{registrationActivity}', [RegistrationActivityController::class, 'destroy'])->name('activities.destroy')->can('delete', \App\Models\RegistrationActivity::class);
//    });

Route::prefix('activities/{activity}')->middleware('auth')->group(function () {
    // Đăng ký tham gia hoạt động
    Route::post('/register', [RegistrationActivityController::class, 'store'])->name('activities.register');

    // Hủy đăng ký tham gia hoạt động
    Route::post('/cancel', [RegistrationActivityController::class, 'destroy'])->name('activities.cancel');
});

