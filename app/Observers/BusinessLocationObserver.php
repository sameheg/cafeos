<?php

namespace App\Observers;

use App\BusinessLocation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\TaggableStore;

class BusinessLocationObserver
{
    public function saved(BusinessLocation $location): void
    {
        $this->clearCaches($location->business_id);
    }

    public function deleted(BusinessLocation $location): void
    {
        $this->clearCaches($location->business_id);
    }

    protected function clearCaches($businessId): void
    {
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(['invoice_schemes', 'business:'.$businessId])->flush();
        } else {
            Cache::flush();
        }
    }
}
