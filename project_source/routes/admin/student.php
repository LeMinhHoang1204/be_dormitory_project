<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\StudentController;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('/students')->group(function () {

        // my room
        Route::get('/my-room', [ResidenceController::class, 'myRoom'])->name('student.room')->can('roomHistory', Room::class);

        // register room
        Route::prefix('/room-registration')->group(function () {

            Route::get('/rooms', [StudentController::class, 'fetchRoomsForStudent'])->name('students.rooms');

            Route::get('/rooms/{room}', [StudentController::class, 'getRoomDataforStudent'])->name('students.rooms');

            Route::get('/current-student-user' , [StudentController::class, 'getCurrentUser'])->name('students.current-user');

            Route::get('/latest-residence', [StudentController::class, 'getLatestResidence'])->name('students.latest-residence');

            Route::get('/', [StudentController::class, 'showRegisterRoomList'])->name('students.register-room.list')->can('registerRoom', Student::class);
            Route::post('/', [StudentController::class, 'showRegisterRoomList']);
            Route::get('/filter-rooms', [StudentController::class, 'showFilteredRoomList'])->name('students.filter-rooms');

            Route::post('/', [StudentController::class, 'registerRoom'])->name('students.register-room.create')->can('registerRoom', Student::class);

        });

        // invoice
        Route::prefix('/invoices')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('showAllInvoices');

            Route::get('/detail/{invoice}', [InvoiceController::class, 'showDetail'])->name('detailInvoice')->can('view', 'invoice');

            Route::post('/detail/confirm/{invoice}', [InvoiceController::class, 'studentConfirmInvoice'])->name('studentConfirmInvoice');

            Route::post('/detail/report/{invoice}', [InvoiceController::class, 'studentReportInvoice'])->name('studentReportInvoice')->can('view', 'invoice');

        });

        // request
        Route::prefix('/requests')->group(function () {

            Route::get('/', [RequestController::class, 'index'])->name('requests.index')->can('viewAny', \App\Models\Request::class);

            Route::get('/detail/{request}', [RequestController::class, 'show'])->name('studentDetailRequest')->can('view', 'request');

            Route::get('/repair-room', [RequestController::class, 'showRepairRequestForm'])->name('students.repair-request');

            Route::post('/repair-room', [RequestController::class, 'createRepairRequest'])->name('students.repair-request.store');

            Route::get('/renew', [RequestController::class, 'showRoomRenewalForm'])->name('students.extend');

            Route::post('/renew', [RequestController::class, 'createRenewalRequest'])->name('students.extend.store');

            Route::get('/checkout', [RequestController::class, 'showCheckOutForm'])->name('students.checkout');

            Route::post('/checkout/{residence}', [RequestController::class, 'leaveRequest'])->name('students.leave');

            Route::get('/change-room', [RequestController::class, 'showChangeRequestForm'])->name('students.change-room-request');

            Route::post('/change-room', [RequestController::class, 'createChangeRoomRequest'])->name('students.change-room-store');

        });


        Route::get('/my_profile', [StudentController::class, 'showProfile'])->name('student.profile');
        //        Route::get('/student/user_profile.php/edit', [StudentController::class, 'editProfile'])->name('student.user_profile.php.edit');
        Route::post('/upload-user_profile.php-image', [StudentController::class, 'updateProfileImage'])->name('user_profile.php.update-image');



        Route::get('/{id}', [StudentController::class, 'getStudentInfo'])->name('student.getInfo');

    });
});
