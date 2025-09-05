<?php

namespace App\Exports;

use App\Services\Accounting\QuickBooksService;
use App\Transaction;
use Maatwebsite\Excel\Concerns\FromArray;

class TransactionsExport implements FromArray
{
    protected QuickBooksService $quickBooksService;

    public function __construct(QuickBooksService $quickBooksService)
    {
        $this->quickBooksService = $quickBooksService;
    }

    public function array(): array
    {
        $business_id = request()->session()->get('user.business_id');

        $transactions = Transaction::where('business_id', $business_id)
            ->with('contact')
            ->get();

        return $this->quickBooksService->mapTransactions($transactions);
    }
}
