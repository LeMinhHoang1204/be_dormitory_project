<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\StudentController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('/students')->group(function () {

        Route::get('/rooms', [\App\Http\Controllers\RoomController::class, 'fetchRoomsForStudent'])->name('students.rooms');

        Route::get('/rooms/{room}', [\App\Http\Controllers\RoomController::class, 'getRoomDataforStudent'])->name('students.rooms');

        Route::get('/current-student-user' , [StudentController::class, 'getCurrentUser'])->name('students.current-user');

        Route::get('/register-room', [StudentController::class, 'showRegisterRoomList'])->name('students.register-room.list');

        Route::post('/register-room', [StudentController::class, 'createNewResidence'])->name('students.register-room.create');

        Route::get('/latest-residence/{userId}', [StudentController::class, 'getLatestResidence'])->name('students.latest-residence');

//        Route::get('/register-room/{room}', [StudentController::class, 'showRegisterRoomForm'])->name('students.register-room.show')->can('registerRoom', Student::class);

//        Route::post('/register-room/{room}', [StudentController::class, 'createNewResidence'])->name('students.register-room.create')->can('registerRoom', Student::class);

        Route::get('/room', [StudentController::class, 'showMyRoom'])->name('students.room');

        Route::get('/repair-request', [StudentController::class, 'showRepairRequestForm'])->name('students.repair-request');

        Route::post('/repair-request', [StudentController::class, 'createRepairRequest'])->name('students.repair-request.store');

        Route::get('/renew', [StudentController::class, 'showRoomRenewalForm'])->name('students.extend');

        Route::post('/renew', [StudentController::class, 'createRenewalRequest'])->name('students.extend.store');

        Route::get('/checkout', [StudentController::class, 'showCheckOutForm'])->name('students.checkout');

        Route::post('/leave', [StudentController::class, 'leaveRequest'])->name('students.leave');

        Route::get('/my_profile', [StudentController::class, 'showProfile'])->name('student.profile');
        //        Route::get('/student/user_profile.php/edit', [StudentController::class, 'editProfile'])->name('student.user_profile.php.edit');
        Route::post('/upload-user_profile.php-image', [StudentController::class, 'updateProfileImage'])->name('user_profile.php.update-image');

        // Payment
        Route::get('/payment', [InvoiceController::class, 'index'])->name('invoice');

        //Payment detail
        Route::get('student_payment/detail_payment/{id}', [InvoiceController::class, 'showDetail'])->name('student_payment.detail_payment');

        Route::post('student_payment/detail_payment/{id}', [ImageController::class, 'upload'])->name('image.upload');
    });
});
