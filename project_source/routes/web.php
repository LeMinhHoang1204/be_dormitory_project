<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


//đăng nhập
Route::get('/', function () {
    return view('Auth_.login');
});

//đăng ký
Route::get('/register-user', function () {
    return view('Auth_.register');
});

//thay đổi mật khẩu
Route::get('/password-user', function () {
    return view('Auth_.password');
});

//xác thực
Route::get('/accept-user', function () {
    return view('Auth_.accept');
});

//thông báo
Route::get('/success-user', function () {
    return view('Auth_.success');
});

//cofirm password
Route::get('/cofirm-user', function () {
    return view('Auth_.cofirm');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
