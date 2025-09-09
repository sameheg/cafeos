<?php

namespace App\Listeners;

use Stancl\Tenancy\Events\TenancyInitialized;

class SetTenantCurrency
{
    public function handle(TenancyInitialized $event): void
    {
        $currency = $event->tenant->get('currency') ?? config('app.currency');
        config(['app.currency' => $currency]);
    }
}
