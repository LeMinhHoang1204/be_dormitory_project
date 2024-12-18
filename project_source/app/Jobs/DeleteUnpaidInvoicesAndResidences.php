<?php

// app/Jobs/DeleteUnpaidInvoicesAndResidences.php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\Residence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteUnpaidInvoicesAndResidences implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle()
    {
        $invoices = Invoice::where('type', 'Room')
            ->where('status', 'Not Paid')
            ->where('send_date', '<=', now()->subDays(7))
            ->get();

        foreach ($invoices as $invoice) {
            $residence = Residence::where('stu_user_id', $invoice->object_id)
                ->where('status', 'Registered')
                ->first();

            if ($residence) {
                $residence->delete();
            }

            $invoice->delete();
        }

        Log::info('Deleted unpaid invoices and residences older than 7 days.');
    }
}
