<?php

namespace Modules\EquipmentLeasing\Listeners;

use Illuminate\Support\Facades\Log;

class PaymentReceivedListener
{
    public function handle(array $payload): void
    {
        Log::info('Payment received', $payload);
    }
}

