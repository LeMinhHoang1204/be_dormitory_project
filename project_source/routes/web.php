<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;

//Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
//Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');
// Routes for building
Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');
Route::get('/buildings/{building}', [BuildingController::class, 'show'])->name('buildings.show');
Route::get('/buildings/{building}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
Route::put('/buildings/{building}', [BuildingController::class, 'update'])->name('buildings.update');
Route::delete('/buildings/{building}', [BuildingController::class, 'destroy'])->name('buildings.destroy');
Route::put('/buildings/{building}/manager', [BuildingController::class, 'updateManager'])->name('buildings.updateManager');



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



Route::get('/student/extension', [RoomController::class, 'showRoomExtensionForm'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Hiển thị trang Checkout
    Route::get('student/checkout', [RoomController::class, 'showCheckOutPage'])->name('student.checkout');

    //     Xử lý yêu cầu Leave
    Route::post('student/leave-request', [RoomController::class, 'leaveRequest'])->name('student.leave');
});
Route::get('/student/leave', [RoomController::class, 'leave'])->name('student.leave');

//Trang Repair request của student
Route::middleware(['auth'])->group(function () {
    // Route trang yêu cầu sửa chữa
    Route::get('/student/repair-request', [RoomController::class, 'repairRequest'])->name('repair-request');
    // Route gửi yêu cầu sửa chữa
    Route::post('/student/repair-request', [RoomController::class, 'storeRepairRequest'])->name('repair-request.store');
});





// Display roomInfor
Route::middleware('auth')->group(function () {
    Route::get('/roomInfor/{roomId}', [RoomController::class, 'showRoomInfor'])->name('roomInfor.roomInfor');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api/building-room.php';
require __DIR__ . '/api/notification.php';