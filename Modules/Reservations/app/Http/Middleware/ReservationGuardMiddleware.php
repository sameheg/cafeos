<?php
namespace Modules\Reservations\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Modules\Reservations\App\Services\ReservationReader;

class ReservationGuardMiddleware
{
    public function __construct(private ReservationReader $reader) {}

    public function handle(Request $request, Closure $next): Response
    {
        $tableId   = $request->input('table_id');
        $tenantId  = tenant('id') ?? null;
        $openAt    = now();

        if ($tableId && $this->reader->hasActiveOrImminentConflict($tenantId, (int)$tableId, $openAt)) {
            return response()->json([
                'message' => 'Table is reserved / time-conflict.',
                'code'    => 'RESERVATION_CONFLICT'
            ], 409);
        }

        return $next($request);
    }
}
