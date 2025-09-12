<?php

namespace Modules\SuperAdmin\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\SuperAdmin\Models\Flag;
use Modules\SuperAdmin\Models\Log;

class FlagObserver
{
    public function updated(Flag $flag): void
    {
        if ($flag->wasChanged('enabled')) {
            Log::create([
                'action' => $flag->enabled ? 'flag_restored' : 'flag_disabled',
                'user_id' => Auth::id(),
                'timestamp' => now(),
                'meta' => [
                    'module' => $flag->module,
                    'tenant_id' => $flag->tenant_id,
                ],
            ]);
        }
    }
}
