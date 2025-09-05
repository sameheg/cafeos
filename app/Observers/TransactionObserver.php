<?php

namespace App\Observers;

use App\Transaction;
use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Cache;

class TransactionObserver
{
    public function saved(Transaction $transaction): void
    {
        $this->clearCaches($transaction->business_id);
    }

    public function deleted(Transaction $transaction): void
    {
        $this->clearCaches($transaction->business_id);
    }

    protected function clearCaches($businessId): void
    {
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(['restaurant_orders', 'business:'.$businessId])->flush();
            Cache::tags(['restaurant_line_orders', 'business:'.$businessId])->flush();
        } else {
            Cache::flush();
        }
    }
}
