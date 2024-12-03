<?php

use App\Http\Controllers\ReportAccountantController;

Route::middleware('auth')->group(function () {
    Route::get('/report_accountant', [ReportAccountantController::class, 'index'])->name('report_accountant.index');
});
