<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // requests
    Route::prefix('/requests')->group(function () {
        });

});
