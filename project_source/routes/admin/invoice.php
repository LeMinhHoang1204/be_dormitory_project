<?php

use App\Http\Controllers\DetailInvoiceController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // invoices
    Route::prefix('/invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index')->can('viewAny', \App\Models\Invoice::class);

        Route::get('/create', [InvoiceController::class, 'create'])->name('invoices.create')->can('create', \App\Models\Invoice::class);

        Route::post('/create', [InvoiceController::class, 'store'])->name('invoices.store');

        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show')->can('view', \App\Models\Invoice::class);

        Route::get('/edit/{invoice}', [InvoiceController::class, 'edit'])->name('invoices.edit')->can('update', \App\Models\Invoice::class);

        Route::post('/edit/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update')->can('update', \App\Models\Invoice::class);

        Route::delete('/delete/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy')->can('delete', \App\Models\Invoice::class);
    });
    // detail invoices
    Route::prefix('/invoices/{invoice}/detailInvoices')->group(function () {
        Route::get('/create', [DetailInvoiceController::class, 'create'])->name('detail-invoices.create')->can('create', \App\Models\DetailInvoice::class);

        Route::post('/create', [DetailInvoiceController::class, 'store'])->name('detail-invoices.store')->can('create', \App\Models\DetailInvoice::class);

        Route::get('/edit/{detailInvoice}', [DetailInvoiceController::class, 'edit'])->name('detail-invoices.edit')->can('update', \App\Models\DetailInvoice::class);

        Route::post('/edit/{detailInvoice}', [DetailInvoiceController::class, 'update'])->name('detail-invoices.update')->can('update', \App\Models\DetailInvoice::class);
        Route::delete('/delete/{detailInvoice}', [DetailInvoiceController::class, 'destroy'])->name('detail-invoices.destroy')->can('delete', \App\Models\DetailInvoice::class);
    });
});
