<?php

use App\Http\Controllers\ReportAccountantController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/report_accountant', [ReportAccountantController::class, 'index'])->name('report_accountant.index');
});
