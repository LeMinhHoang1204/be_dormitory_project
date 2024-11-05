<?php

use App\Http\Controllers\StudentController;
use Illuminate\Routing\Route;

Route::get('namelist', [StudentController::class, 'index']);
