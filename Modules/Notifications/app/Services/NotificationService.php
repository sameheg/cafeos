<?php

namespace Modules\Notifications\Services;

use Modules\Notifications\Channels\EmailChannel;
use Modules\Notifications\Channels\InAppChannel;
use Modules\Notifications\Channels\PushChannel;
use Modules\Notifications\Channels\SmsChannel;

class NotificationService
{
    /** @var array<string, object> */
    protected array $channels;

    public function __construct()
    {
        $this->channels = [
            'in-app' => new InAppChannel(),
            'email' => new EmailChannel(),
            'sms' => new SmsChannel(),
            'push' => new PushChannel(),
        ];
    }

    /**
     * Send a message through the given channels.
     *
     * @param string $message
     * @param array<int, string> $channels
     */
    public function send(string $message, array $channels): void
    {
        foreach ($channels as $channel) {
            $this->channels[$channel]->send($message);
        }
    }
}
