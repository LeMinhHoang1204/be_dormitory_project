<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // building manager check in requests
    Route::prefix('/building-manager/check-in-requests')->group(function () {

        Route::get('/', [RequestController::class, 'getCheckInReq'])->name('requests.getCheckInReq')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

        Route::get('/detail/{id}', [RequestController::class, 'getDetailCheckInReq'])->name('requests.getDetailCheckInReq')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

        Route::post('/detail/accept/{id}', [RequestController::class, 'acceptCheckIn'])->name('requests.acceptCheckIn')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

        Route::post('/detail/reject/{residence}', [RequestController::class, 'rejectCheckIn'])->name('requests.rejectCheckIn')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

        Route::get('/tranfer-room/{residence}', [RequestController::class, 'getTransferCheckInReq'])->name('requests.getTransferCheckInReq')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

        Route::post('/tranfer-room/{residence}', [RequestController::class, 'acceptTransferCheckInReq'])->name('requests.acceptTransferCheckInReq')->can('viewAcceptRejectTransferCheckInReq', \App\Models\Request::class);

    });

    // building manager all requests
    Route::prefix('/building-manager/requests')->group(function () {

        Route::get('/', [RequestController::class, 'index'])->name('requests.index')->can('viewAny', \App\Models\Request::class);

        Route::get('/{request}', [RequestController::class, 'show'])->name('requests.show')->can('view', 'request');

        Route::delete('/delete/{request}', [RequestController::class, 'destroy'])->name('requests.destroy')->can('delete', 'request');

        Route::post('/accept/{request}', [RequestController::class, 'accept'])->name('requests.accept')->can('confirmRequest', 'request');

        Route::post('/reject/{request}', [RequestController::class, 'reject'])->name('requests.reject')->can('confirmRequest', 'request');

        Route::post('/resolve/{request}', [RequestController::class, 'resolve'])->name('requests.resolve')->can('resolveRequest', 'request');

    });

});
