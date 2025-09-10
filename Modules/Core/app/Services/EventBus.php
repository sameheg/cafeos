<?php

namespace Modules\Core\Services;

use App\Models\Tenant;
use Illuminate\Contracts\Events\Dispatcher;

class EventBus
{
    public function __construct(protected Dispatcher $dispatcher) {}

    /**
     * Dispatch an event within the current tenant context.
     *
     * @param  array<int,mixed>  $payload
     */
    public function dispatch(object|string $event, array $payload = []): void
    {
        $this->dispatcher->dispatch($event, $payload);
    }

    /**
     * Dispatch an event for a specific tenant.
     *
     * @param  array<int,mixed>  $payload
     */
    public function dispatchToTenant(Tenant $tenant, object|string $event, array $payload = []): void
    {
        tenancy()->initialize($tenant);
        $this->dispatch($event, $payload);
        tenancy()->end();
    }
}
