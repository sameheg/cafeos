<?php

namespace Modules\Notifications\Channels;

use Illuminate\Support\Facades\Log;

class EmailChannel
{
    public function send(string $message): void
    {
        Log::info('Email notification: '.$message);
    }
}
