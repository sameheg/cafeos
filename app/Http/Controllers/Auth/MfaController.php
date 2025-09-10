<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MfaController extends Controller
{
    /**
     * Send an MFA code to the authenticated user.
     */
    public function challenge(Request $request)
    {
        abort_unless(config('security.mfa.enabled'), 404);

        $user = $request->user();
        $code = (string) random_int(100000, 999999);

        Cache::put($this->cacheKey($user->id), $code, now()->addMinutes(5));

        Log::channel('audit')->info('mfa.challenge.sent', [
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'MFA code sent']);
    }

    /**
     * Verify the provided MFA code.
     */
    public function verify(Request $request)
    {
        abort_unless(config('security.mfa.enabled'), 404);

        $validated = $request->validate([
            'code' => ['required', 'string'],
        ]);

        $user = $request->user();
        $key = $this->cacheKey($user->id);
        $valid = Cache::pull($key);

        if ($valid && hash_equals($valid, $validated['code'])) {
            Log::channel('audit')->info('mfa.challenge.verified', [
                'user_id' => $user->id,
            ]);

            return response()->json(['message' => 'MFA verified']);
        }

        Log::channel('audit')->warning('mfa.challenge.failed', [
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Invalid MFA code'], 422);
    }

    private function cacheKey(int $userId): string
    {
        return 'mfa_code_'.$userId;
    }
}
