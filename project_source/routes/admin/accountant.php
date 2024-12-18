<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('/accountant')->group(function () {

        // invoice
        Route::prefix('/invoices')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('showAllInvoices');

            Route::get('/detail_invoices/{invoice}', [InvoiceController::class, 'showDetail'])->name('accountantDetailInvoice')->can('update', 'invoice');

            Route::post('/detail_invoices/confirm/{invoice}', [InvoiceController::class, 'accountantConfirmInvoice'])->name('accountantConfirmInvoice')->can('update', 'invoice');

            Route::get('/detail_invoices/report/{id}', [InvoiceController::class, 'reportInvoice'])->name('reportInvoice')->can('update', 'invoice');

        });
    });
});
