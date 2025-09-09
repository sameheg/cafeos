<?php

namespace Modules\Notifications\Channels;

use Illuminate\Support\Facades\Log;

class InAppChannel
{
    public function send(string $message): void
    {
        Log::info('In-app notification: '.$message);
    }
}
