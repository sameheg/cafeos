<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tenant.{tenantId}.kds.station.{stationId}', function ($user, int $tenantId): bool {
    return (int) $user->tenant_id === $tenantId;
});

