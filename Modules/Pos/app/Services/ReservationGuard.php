<?php

namespace Modules\Pos\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Pos\Models\PosTable;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ReservationGuard
{
    public static function ensureStartAllowed(PosTable $table): void
    {
        if (!Schema::hasTable('reservations')) return;
        $now = now();
        $conflict = DB::table('reservations')
            ->where('tenant_id',$table->tenant_id)
            ->where('table_id',$table->id)
            ->whereIn('status',['reserved','confirmed'])
            ->where('start_at','<=',$now)
            ->where('end_at','>=',$now)
            ->exists();
        if ($conflict) {
            throw new ConflictHttpException('Table is reserved right now; cannot start order.');
        }
    }
}
