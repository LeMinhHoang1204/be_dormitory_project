<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // building manager check in requests
    Route::prefix('/building-manager/check-in-requests')->group(function () {

        Route::get('/', [RequestController::class, 'getCheckInReq'])->name('requests.getCheckInReq')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

        Route::get('/detail/{id}', [RequestController::class, 'getDetailCheckInReq'])->name('requests.getDetailCheckInReq')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

        Route::post('/detail/accept/{id}', [RequestController::class, 'acceptCheckIn'])->name('requests.acceptCheckIn')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

        Route::post('/detail/reject/{id}', [RequestController::class, 'rejectCheckIn'])->name('requests.rejectCheckIn')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

        Route::get('/tranfer-room/{id}', [RequestController::class, 'getTransferCheckInReq'])->name('requests.getTransferCheckInReq')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

        Route::post('/tranfer-room/{id}', [RequestController::class, 'acceptTransferCheckInReq'])->name('requests.acceptTransferCheckInReq')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

    });

});
