<?php

namespace App\Services\Accounting;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class QuickBooksService
{
    /**
     * Map transactions to QuickBooks format.
     *
     * @param \Illuminate\Support\Collection $transactions
     * @return array
     */
    public function mapTransactions(Collection $transactions): array
    {
        $rows = [['TxnDate', 'DocNumber', 'Contact', 'Amount']];

        foreach ($transactions as $transaction) {
            $rows[] = [
                'TxnDate' => Carbon::parse($transaction->transaction_date)->toDateString(),
                'DocNumber' => $transaction->ref_no,
                'Contact' => optional($transaction->contact)->name,
                'Amount' => $transaction->final_total,
            ];
        }

        return $rows;
    }
}
