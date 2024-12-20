<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('update:invoices', function () {
    \App\Jobs\UpdateOverdueInvoices::dispatch();
    $this->info('Dispatched UpdateOverdueInvoices job.');
})->describe('Dispatch the UpdateOverdueInvoices job');

Artisan::command('delete:unpaid-invoices', function () {
    \App\Jobs\DeleteUnpaidInvoicesAndResidences::dispatch();
    $this->info('Dispatched DeleteUnpaidInvoicesAndResidences job.');
})->describe('Dispatch the DeleteUnpaidInvoicesAndResidences job');
