<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ResidenceController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/my-room', [ResidenceController::class, 'myRoom'])->name('student.room');
});
Route::get('/student/extension', [RoomController::class, 'showRoomExtensionForm'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('student/checkout', [RoomController::class, 'showCheckOutPage'])->name('student.checkout');

    //     Xử lý yêu cầu Leave
    Route::post('student/leave-request', [RoomController::class, 'leaveRequest'])->name('student.leave');
});
Route::get('/student/leave', [RoomController::class, 'leave'])->name('student.leave');

Route::middleware(['auth'])->group(function () {
    // Route trang yêu cầu sửa chữa
    Route::get('/student/repair-request', [RoomController::class, 'repairRequest'])->name('repair-request');
    // Route gửi yêu cầu sửa chữa
    Route::post('/student/repair-request', [RoomController::class, 'storeRepairRequest'])->name('repair-request.store');
});

Route::get('/regis-test', function () {
    return view('/Reg_room/reg_room');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/report', function () {
    return view('/Report/report_accountant');
});

Route::get('/student-report', function () {
    return view('/Report/report_student');
});




// Display roomInfor
Route::middleware('auth')->group(function () {
    Route::get('/roomInfor/{roomId}', [RoomController::class, 'showRoomInfor'])->name('roomInfor.roomInfor');
});

Route::get('/roomInfor/{id}', [RoomController::class, 'showRoom']);

//Xem trang thông tin phòng hiện tại của tôi
Route::middleware('auth')->group(function () {
    Route::get('/student/room', [ResidenceController::class, 'myRoom'])->name('student.room');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api/building-room-residence.php';
require __DIR__ . '/api/notification.php';
