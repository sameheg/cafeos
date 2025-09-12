<?php

namespace Modules\Pos\Listeners;

use Modules\Pos\Models\PosAudit;

class WriteAudit
{
    public function handle(object $event): void
    {
        $payload = method_exists($event, 'toAudit') ? $event->toAudit() : [];
        if (!$payload) return;
        PosAudit::create($payload);
    }
}
