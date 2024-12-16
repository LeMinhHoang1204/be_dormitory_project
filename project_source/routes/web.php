<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ReportAccountantController;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
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

Route::get('/roomInfor/{id}', [RoomController::class, 'showRoom']);

//Xem trang thông tin phòng hiện tại của tôi
Route::middleware('auth')->group(function () {
    Route::get('/student/room', [ResidenceController::class, 'myRoom'])->name('student.room');
});

Route::post('/vnpay_payment', [PaymentController::class, 'vnpay_payment'])->name('vnpay_payment');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin/notification.php';
require __DIR__ . '/admin/building-room-residence.php';
require __DIR__ . '/admin/student.php';
require __DIR__ . '/admin/activity.php';
require __DIR__ . '/admin/asset.php';
require __DIR__ . '/admin/invoice.php';
require __DIR__ . '/admin/request.php';
require __DIR__ . '/admin/my_profile.php';
require __DIR__ . '/admin/report.php';


