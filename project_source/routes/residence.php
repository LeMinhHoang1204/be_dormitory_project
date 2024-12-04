<?php
use App\Http\Controllers\ResidenceController;

Route::middleware('auth')->group(function () {
    Route::get('/my-room', [ResidenceController::class, 'myRoom'])->name('student.room');
});

require __DIR__ . '/auth.php';
