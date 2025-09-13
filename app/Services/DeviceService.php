<?php

namespace App\Services;

use App\Events\Device\DeviceAlert;

class DeviceService
{
    public function alert(string $deviceId, string $message): void
    {
        DeviceAlert::dispatch($deviceId, $message);
    }
}
