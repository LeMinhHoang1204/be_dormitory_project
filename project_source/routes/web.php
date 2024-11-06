<?php

use App\Events\UserLogin;
use App\Events\UserRegistration;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function (Request $request) {
    // Check if the 'login' query parameter is present and true
//    if ($request->query('login') === 'true') {
//        // Process if the login parameter is true
//        // For example, set a session variable or trigger an action
//        event(new \App\Events\UserLogin('LEMINHHOANG'));
//    }

    event(new UserLogin($request->user()->email));
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
