<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;



Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');

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


//// Route hiển thị trang gia hạn phòng
//Route::get('/student/room/extension', [RoomController::class, 'showRoomExtensionForm'])->middleware('auth')->name('student.room.extension');
//// Route xử lý khi người dùng gửi form gia hạn
//Route::post('/student/room/extension', [RoomController::class, 'extendRoomContract'])->middleware('auth')->name('student.room.extension.submit');
Route::get('/student/extension', [RoomController::class, 'showRoomExtensionForm'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Hiển thị trang Checkout
    Route::get('student/checkout', [RoomController::class, 'showCheckOutPage'])->name('student.checkout');

    //     Xử lý yêu cầu Leave
    Route::post('student/leave-request', [RoomController::class, 'leaveRequest'])->name('student.leave');
});
Route::get('/student/leave', [RoomController::class, 'leave'])->name('student.leave');


// Hien thi roomInfor
Route::get('/roomInfor', function () {
    return view('roomInfor.roomInfor');
});

Route::get('/roomInfor', [RoomController::class, 'showRoomInfor']);

// Nhan thong tin room
Route::get('/roomInfor/{roomId}', [RoomController::class, 'showRoomInfor'])->name('roomInfor');



require __DIR__ . '/auth.php';
require __DIR__ . '/api/building-room.php';
require __DIR__ . '/api/notification.php';