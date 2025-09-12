<?php
namespace Modules\Reservations\App\Services;

use Illuminate\Support\Facades\DB;

class ReservationReader
{
    public function hasActiveOrImminentConflict(?int $tenantId, int $tableId, \DateTimeInterface $at): bool
    {
        $windowStart = (clone $at)->modify('-15 minutes');
        $windowEnd   = (clone $at)->modify('+15 minutes');

        return DB::table('reservations')
            ->when($tenantId, fn($q) => $q->where('tenant_id', $tenantId))
            ->where('table_id', $tableId)
            ->whereIn('status', ['confirmed','seated'])
            ->where(function ($q) use ($windowStart, $windowEnd) {
                $q->whereBetween('start_at', [$windowStart, $windowEnd])
                  ->orWhereBetween('end_at',   [$windowStart, $windowEnd])
                  ->orWhere(function($q2) use ($windowStart, $windowEnd) {
                      $q2->where('start_at', '<=', $windowStart)
                         ->where('end_at',   '>=', $windowEnd);
                  });
            })
            ->exists();
    }
}
