<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // requests
    Route::prefix('/requests')->group(function () {
        Route::get('/', [RequestController::class, 'index'])->name('requests.index')->can('viewAny', \App\Models\Request::class);

        Route::get('/create', [RequestController::class, 'create'])->name('requests.create')->can('create', \App\Models\Request::class);

        Route::post('/create', [RequestController::class, 'store'])->name('requests.store')->can('create', \App\Models\Request::class);

        Route::get('/{request}', [RequestController::class, 'show'])->name('requests.show')->can('view', \App\Models\Request::class);

        Route::get('/edit/{request}', [RequestController::class, 'edit'])->name('requests.edit')->can('update', \App\Models\Request::class);

        Route::post('/edit/{request}', [RequestController::class, 'update'])->name('requests.update')->can('update', \App\Models\Request::class);

        Route::delete('/delete/{request}', [RequestController::class, 'destroy'])->name('requests.destroy')->can('delete', \App\Models\Request::class);
    });

});
