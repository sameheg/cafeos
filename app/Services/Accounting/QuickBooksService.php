<?php

namespace App\Services\Accounting;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class QuickBooksService implements AccountingInterface
{
    /**
     * {@inheritdoc}
     */
    public function syncInvoice(array $invoice): bool
    {
        // This is a placeholder implementation.
        // In a real scenario this would push the invoice to QuickBooks via API.
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function mapTax(array $tax): array
    {
        // Map local tax data to QuickBooks specific fields.
        return $tax;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(array $credentials): bool
    {
        // Perform authentication with QuickBooks API.
        return true;
    }

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
