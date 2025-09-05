<?php

namespace App\Observers;

use App\InvoiceScheme;
use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\TaggableStore;

class InvoiceSchemeObserver
{
    public function saved(InvoiceScheme $scheme): void
    {
        $this->clearCaches($scheme->business_id);
    }

    public function deleted(InvoiceScheme $scheme): void
    {
        $this->clearCaches($scheme->business_id);
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
