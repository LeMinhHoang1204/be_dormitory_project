<?php
// app/Jobs/UpdateOverdueInvoices.php

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateOverdueInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle()
    {
        $invoices = Invoice::where('status', 'Unpaid')
            ->where('end_date', '<', now())
            ->whereNull('paid_date')
            ->get();

        foreach ($invoices as $invoice) {
            $invoice->update(['status' => 'Overdue']);
        }

        Log::info('Updated overdue invoices.');
    }
}
