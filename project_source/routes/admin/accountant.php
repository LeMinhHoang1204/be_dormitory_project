<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('/accountant')->group(function () {

        // request
        Route::prefix('/requests')->group(function () {
            Route::get('/', [RequestController::class, 'index'])->name('showAllAccountantRequests');

            Route::get('/detail/{request}', [RequestController::class, 'show'])->name('accountantDetailRequest')->can('view', 'request');

            Route::post('/accept/{request}', [RequestController::class, 'accept'])->name('accountantAcceptRequest')->can('confirmRequest', 'request');

            Route::post('/reject/{request}', [RequestController::class, 'reject'])->name('accountantRejectRequest')->can('confirmRequest', 'request');

            Route::post('/resolve/{request}', [RequestController::class, 'resolve'])->name('accountantResolveRequest')->can('confirmRequest', 'request');

        });

        // invoice
        Route::prefix('/invoices')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('showAllInvoices');

            Route::get('/detail/{invoice}', [InvoiceController::class, 'showDetail'])->name('accountantDetailInvoice')->can('update', 'invoice');

            Route::post('/detail/confirm/{invoice}', [InvoiceController::class, 'accountantConfirmInvoice'])->name('accountantConfirmInvoice')->can('update', 'invoice');

            Route::get('/detail/report/{id}', [InvoiceController::class, 'reportInvoice'])->name('reportInvoice')->can('update', 'invoice');

            Route::get('/create', [InvoiceController::class, 'create'])->name('invoices.create');

            Route::post('/create', [InvoiceController::class, 'store'])->name('invoices.store');

        });
    });
});
