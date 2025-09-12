<?php

namespace Modules\Billing\Listeners;

use Illuminate\Contracts\Events\Dispatcher;

class MembershipRenewedListener
{
    public function subscribe(Dispatcher $events): void
    {
        $events->listen('membership.renewed@v1', [self::class, 'handle']);
    }

    public function handle(array $payload): void
    {
        // Idempotent handler for membership renewal events
        // Real implementation would generate an invoice for renewed memberships
    }
}
