<?php

namespace Modules\Notifications\Channels;

use Illuminate\Support\Facades\Log;

class SmsChannel
{
    public function send(string $message): void
    {
        Log::info('SMS notification: '.$message);
    }
}
