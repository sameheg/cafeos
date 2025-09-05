<?php

namespace App\Observers;

use App\Transaction;
use App\TransactionSellLine;
use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Cache;

class TransactionSellLineObserver
{
    public function saved(TransactionSellLine $line): void
    {
        $this->clearCaches($line);
    }

    public function deleted(TransactionSellLine $line): void
    {
        $this->clearCaches($line);
    }

    protected function clearCaches(TransactionSellLine $line): void
    {
        $businessId = Transaction::where('id', $line->transaction_id)->value('business_id');

        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(['restaurant_orders', 'business:'.$businessId])->flush();
            Cache::tags(['restaurant_line_orders', 'business:'.$businessId])->flush();
        } else {
            Cache::flush();
        }
    }
}
