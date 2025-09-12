<?php
namespace Modules\Pos\App\Services;

use Illuminate\Support\Facades\Log;

class PosAudit
{
    public function log(string $action, array $context = []): void
    {
        Log::info('[POS-AUDIT] '.$action, $context + ['ts' => now()->toIso8601String()]);
    }
}
