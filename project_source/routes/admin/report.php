<?php

use App\Http\Controllers\ReportAccountantController;
use App\Http\Controllers\ReportStudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/report_accountant', [ReportAccountantController::class, 'index'])->name('report_accountant.index');
    Route::post('/report_accountant/fetch', [ReportAccountantController::class, 'index'])->name('report_accountant.fetch');
    //student
    Route::get('/report_student', [ReportAccountantController::class, 'studentIndex'])->name('report_student.studentIndex');
});

