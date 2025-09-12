<?php

namespace Modules\Loyalty\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Modules\Loyalty\Models\LoyaltyPoint;

class LoyaltyController extends Controller
{
    public function balance(Request $request, string $customer_id)
    {
        $tenantId = $request->user()?->tenant_id ?? 'tenant-demo';
        $wallet = LoyaltyPoint::where('tenant_id', $tenantId)->where('customer_id', $customer_id)->first();
        if (!$wallet) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return ['balance' => $wallet->balance];
    }

    public function redeem(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|string',
            'points' => 'required|integer|min:1',
        ]);

        $key = sprintf('redeem:%s:%s', $data['customer_id'], $request->ip());
        if (RateLimiter::tooManyAttempts($key, 100)) {
            return response()->json(['message' => 'Rate limit exceeded'], 429);
        }
        RateLimiter::hit($key, 3600);

        $tenantId = $request->user()?->tenant_id ?? 'tenant-demo';

        return DB::transaction(function () use ($data, $tenantId) {
            $wallet = LoyaltyPoint::where('tenant_id', $tenantId)
                ->where('customer_id', $data['customer_id'])
                ->lockForUpdate()
                ->first();

            if (!$wallet || $wallet->balance < $data['points']) {
                return response()->json(['success' => false], 402);
            }

            $wallet->balance -= $data['points'];
            $wallet->save();

            return ['success' => true];
        });
    }
}
