<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/user/my_profile', [ProfileController::class, 'myProfile'])->name('user_profile.show');
    Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.update-image');

//    Route::prefix('/students')->group(function () {
//        Route::get('/user_profile', [StudentController::class, 'showProfile'])->name('student.user_profile.php');
//        Route::get('/student/user_profile.php/edit', [StudentController::class, 'editProfile'])->name('student.user_profile.php.edit');
//        Route::post('/upload-user_profile.php-image', [StudentController::class, 'updateProfileImage'])->name('user_profile.php.update-image');
//    });
});
