<?php

use App\Http\Controllers\ReportAccountantController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/report_accountant', [ReportAccountantController::class, 'index'])->name('report_accountant.index');
    //student
    Route::get('/report_student', [ReportAccountantController::class, 'studentIndex'])->name('report_student.studentIndex');
    //Manager
    Route::get('/report_manager', [ReportAccountantController::class, 'managerIndex'])->name('report_manager.managerIndex');
});

