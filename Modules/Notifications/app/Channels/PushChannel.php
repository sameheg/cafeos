<?php

namespace Modules\Notifications\Channels;

use Illuminate\Support\Facades\Log;

class PushChannel
{
    public function send(string $message): void
    {
        Log::info('Push notification: '.$message);
    }
}
