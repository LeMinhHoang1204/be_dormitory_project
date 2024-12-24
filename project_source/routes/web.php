<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/students/check-login', [StudentController::class, 'studentCheckLogin'])
    ->name('studentCheckLogin');

// Display roomInfor
Route::middleware('auth')->group(function () {
    Route::get('/roomInfor/{roomId}', [RoomController::class, 'showRoomInfor'])->name('roomInfor.roomInfor');
});

//Route::get('/room-registration', [RoomController::class, 'showListRoom'])->name('register-room');

//Route::get('/roomInfor', [RoomController::class, 'showRoomInfor'])->name('roomInfor');
//
//Route::post('/room-registration', [ResidenceController::class, 'store'])->name('register.room');

// Route::get('/payment', function () {
//     return view('student_payment.payment');
// })->name('payment');

// Payment for accountant
Route::get('/accountant/payment', [PaymentController::class, 'accountantPaymentView'])
    ->name('accountant.act-payment')
    ->middleware('auth');

// Payment routes for accountant
Route::prefix('accountant/payment')->middleware(['auth'])->group(function () {
    Route::post('/confirm/{id}', [PaymentController::class, 'confirm']);
    Route::post('/refuse/{id}', [PaymentController::class, 'refuse']);
    Route::post('/report/{id}', [PaymentController::class, 'report']);
    Route::delete('/delete/{id}', [PaymentController::class, 'delete']);
    Route::get('/get/{id}', [PaymentController::class, 'getInvoice']);
    Route::put('/update/{id}', [PaymentController::class, 'update']);
});

Route::delete('/accountant/payment/delete/{id}', [PaymentController::class, 'delete'])->name('payment.delete');

// Xem trang thông tin phòng hiện tại của tôi
Route::middleware('auth')->group(function () {
    Route::get('/student/room', [ResidenceController::class, 'myRoom'])->name('student.room');
});

Route::post('/vnpay_payment', [PaymentController::class, 'vnpay_payment'])->name('vnpay_payment');

Route::get('/get-rooms-by-building/{buildingId}', [RoomController::class, 'getRoomsByBuilding']);

require __DIR__ . '/auth.php';
require __DIR__ . '/admin/notification.php';
require __DIR__ . '/admin/building-room-residence.php';
require __DIR__ . '/admin/student.php';
require __DIR__ . '/admin/accountant.php';

require __DIR__ . '/admin/activity.php';
require __DIR__ . '/admin/invoice.php';
require __DIR__ . '/admin/my_profile.php';
require __DIR__ . '/admin/manager.php';
require __DIR__ . '/admin/report.php';

require __DIR__ . '/violation.php';

// Thêm route group với middleware auth và role
Route::middleware(['auth', 'role:admin,accountant'])->group(function () {
    Route::get('/invoices/create', 'InvoiceController@create')->name('invoices.create');
    Route::post('/invoices', 'InvoiceController@store')->name('invoices.store');
});
