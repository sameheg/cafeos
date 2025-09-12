<?php

namespace Modules\Membership\Listeners;

use Illuminate\Contracts\Events\Dispatcher;
use Modules\Membership\Models\Membership;

class BillingPaymentSuccessListener
{
    public function subscribe(Dispatcher $events): void
    {
        $events->listen('billing.payment.success', [self::class, 'handle']);
    }

    public function handle(array $payload): void
    {
        // Idempotent handler for payment success
        $membership = Membership::find($payload['member_id'] ?? null);
        if ($membership) {
            $membership->status = 'active';
            $membership->save();
        }
    }
}
