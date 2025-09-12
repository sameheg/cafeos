<?php

namespace Modules\Reservations\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Modules\Reservations\App\Services\ReservationReader;

/**
 * يمنع فتح طلب على طاولة محجوزة (أو متعارض وقتيًا) قبل إنشاء الأوردر.
 * يعمل فقط لو الفلاج pos.strict_reservation_guard مفعّل.
 */
class ReservationGuardMiddleware
{
    public function __construct(private ReservationReader $reader) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (!config('pos.strict_reservation_guard', true)) {
            return $next($request);
        }

        $tableId   = $request->input('table_id');
        $tenantId  = tenant('id') ?? null;
        $openAt    = now();

        if (!$tableId) {
            return $next($request);
        }

        $conflict = $this->reader->hasActiveOrImminentConflict(
            tenantId: $tenantId,
            tableId:  (int)$tableId,
            at:       $openAt
        );

        if ($conflict) {
            return response()->json([
                'message' => 'Table is reserved / time-conflict. Choose another table or cancel reservation.',
                'code'    => 'RESERVATION_CONFLICT'
            ], 409);
        }

        return $next($request);
    }
}
