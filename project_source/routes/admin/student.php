<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RequestController;
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

            Route::get('/latest-residence', [StudentController::class, 'getLatestResidence'])->name('students.latest-residence');

            Route::get('/', [StudentController::class, 'showRegisterRoomList'])->name('students.register-room.list')->can('registerRoom', Student::class);

            Route::post('/', [StudentController::class, 'registerRoom2'])->name('students.register-room.create')->can('registerRoom', Student::class);

        });

        // invoice
        Route::prefix('/invoices')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('showAllInvoices');

            Route::get('/detail/{invoice}', [InvoiceController::class, 'showDetail'])->name('detailInvoice')->can('view', 'invoice');

            Route::post('/detail/confirm/{id}', [InvoiceController::class, 'studentConfirmInvoice'])->name('studentConfirmInvoice');

            Route::get('/detail/report/{id}', [InvoiceController::class, 'reportInvoice'])->name('reportInvoice')->can('view', 'invoice');

        });

        // request
        Route::prefix('/requests')->group(function () {
            Route::get('/', [RequestController::class, 'index'])->name('requests.index')->can('viewAny', \App\Models\Request::class);

            Route::get('/repair-request', [StudentController::class, 'showRepairRequestForm'])->name('students.repair-request');

            Route::post('/repair-request', [StudentController::class, 'createRepairRequest'])->name('students.repair-request.store');

            Route::get('/renew', [StudentController::class, 'showRoomRenewalForm'])->name('students.extend');

            Route::post('/renew', [StudentController::class, 'createRenewalRequest'])->name('students.extend.store');

            Route::get('/checkout', [StudentController::class, 'showCheckOutForm'])->name('students.checkout');

            Route::post('/leave', [StudentController::class, 'leaveRequest'])->name('students.leave');

        });


        Route::get('/my-room', [ResidenceController::class, 'myRoom'])->name('student.room');


        Route::get('/my_profile', [StudentController::class, 'showProfile'])->name('student.profile');
        //        Route::get('/student/user_profile.php/edit', [StudentController::class, 'editProfile'])->name('student.user_profile.php.edit');
        Route::post('/upload-user_profile.php-image', [StudentController::class, 'updateProfileImage'])->name('user_profile.php.update-image');



        Route::get('/{id}', [StudentController::class, 'getStudentInfo'])->name('student.getInfo');

    });
});
