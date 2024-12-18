<?php

use App\Http\Controllers\ComplaintViolationController;
use App\Http\Controllers\ViolationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('/violations')->group(function () {

        Route::get('/', [ViolationController::class, 'indexManager'])->name('violations.indexManager');
        Route::get('/my-violations', [ViolationController::class, 'myViolations'])->name('violations.my');
        Route::get('/create', [ViolationController::class, 'create'])->name('admin.violations.create');
        Route::post('/store', [ViolationController::class, 'store'])->name('admin.violations.store');
        Route::get('/admin/search-students', [ViolationController::class, 'searchStudents'])->name('admin.search_students');
        Route::get('/{id}', [ViolationController::class, 'show'])->name('violations.show');
        Route::delete('/delete/{id}', [ViolationController::class, 'destroy'])
            ->name('violation.destroy')
            ->middleware(['auth']);
        Route::get('/{id}/complaint', [ViolationController::class, 'complaint'])->name('violations.complaint');
        Route::post('/complaints', [ComplaintViolationController::class, 'store'])->name('complaints.store');


        Route::get('/complaints/{id}', [ComplaintViolationController::class, 'show'])->name('complaints.show');
        Route::post('/complaints/{complaint}/accept', [ComplaintViolationController::class, 'accept'])->name('complaint.accept');
        Route::post('/complaints/{complaint}/decline', [ComplaintViolationController::class, 'decline'])->name('complaint.decline');

    });
    Route::get('/admin/complaints', [ComplaintViolationController::class, 'index'])->name('admin.complaints.index');
    Route::get('/my-complaints', [ComplaintViolationController::class, 'myComplaints'])->name('complaints.myComplaints');
    Route::delete('/complaints/{complaint}', [ComplaintViolationController::class, 'destroy'])->name('complaint.destroy');
    Route::get('/violations/{violation}/edit', [ViolationController::class, 'edit'])->name('violations.edit');
    Route::put('/violations/{violation}', [ViolationController::class, 'update'])->name('violations.update');
});
