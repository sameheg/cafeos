<?php

namespace Modules\Billing\Services;

use Modules\Billing\Models\Invoice;

class DunningHandler
{
    public function handle(Invoice $invoice): string
    {
        if ($invoice->status === 'overdue') {
            $invoice->status = 'suspended';
            $invoice->save();
        }

        return $invoice->status;
    }
}
