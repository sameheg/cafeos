<?php

namespace Modules\ArMenu\Services;

class FallbackDetector
{
    public function isWeakDevice(array $metrics): bool
    {
        return ($metrics['memory'] ?? 0) < 512 || ($metrics['cpu'] ?? 0) < 2;
    }
}
