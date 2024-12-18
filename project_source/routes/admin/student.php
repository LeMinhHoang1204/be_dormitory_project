<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\StudentController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('/students')->group(function () {

        // register room
        Route::prefix('/room-registration')->group(function () {
            Route::get('/rooms', [StudentController::class, 'fetchRoomsForStudent'])->name('students.rooms');

            Route::get('/rooms/{room}', [StudentController::class, 'getRoomDataforStudent'])->name('students.rooms');

            Route::get('/current-student-user' , [StudentController::class, 'getCurrentUser'])->name('students.current-user');

            Route::get('/latest-residence/{userId}', [StudentController::class, 'getLatestResidence'])->name('students.latest-residence');

            Route::get('/', [StudentController::class, 'showRegisterRoomList'])->name('students.register-room.list');

            Route::post('/', [StudentController::class, 'registerRoom'])->name('students.register-room.create');

        });

        // invoice
        Route::prefix('/invoices')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('showAllInvoices');

            Route::get('/detail/{invoice}', [InvoiceController::class, 'showDetail'])->name('detailInvoice')->can('view', 'invoice');

            Route::post('/detail/confirm/{id}', [InvoiceController::class, 'studentConfirmInvoice'])->name('studentConfirmInvoice')->can('view', 'invoice');

            Route::get('/detail/report/{id}', [InvoiceController::class, 'reportInvoice'])->name('reportInvoice')->can('view', 'invoice');

        });

        Route::get('/my-room', [ResidenceController::class, 'myRoom'])->name('student.room');

        Route::get('/repair-request', [StudentController::class, 'showRepairRequestForm'])->name('students.repair-request');

        Route::post('/repair-request', [StudentController::class, 'createRepairRequest'])->name('students.repair-request.store');

        Route::get('/renew', [StudentController::class, 'showRoomRenewalForm'])->name('students.extend');

        Route::post('/renew', [StudentController::class, 'createRenewalRequest'])->name('students.extend.store');

        Route::get('/checkout', [StudentController::class, 'showCheckOutForm'])->name('students.checkout');

        Route::post('/leave', [StudentController::class, 'leaveRequest'])->name('students.leave');

        Route::get('/my_profile', [StudentController::class, 'showProfile'])->name('student.profile');
        //        Route::get('/student/user_profile.php/edit', [StudentController::class, 'editProfile'])->name('student.user_profile.php.edit');
        Route::post('/upload-user_profile.php-image', [StudentController::class, 'updateProfileImage'])->name('user_profile.php.update-image');



        Route::get('/{id}', [StudentController::class, 'getStudentInfo'])->name('student.getInfo');

    });
});
