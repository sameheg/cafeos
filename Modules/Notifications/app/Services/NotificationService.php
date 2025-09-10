<?php

namespace Modules\Notifications\Services;

use Modules\Notifications\Channels\EmailChannel;
use Modules\Notifications\Channels\InAppChannel;
use Modules\Notifications\Channels\PushChannel;
use Modules\Notifications\Channels\SmsChannel;
use Modules\Notifications\Models\Notification;

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
     * Send a message through the given channels and store it.
     *
     * @param string $message
     * @param array<int, string> $channels
     * @param string $role
     */
    public function send(string $message, array $channels, string $role = 'user'): Notification
    {
        foreach ($channels as $channel) {
            $this->channels[$channel]->send($message);
        }

        return Notification::create([
            'tenant_id' => null,
            'message' => $message,
            'role' => $role,
            'status' => 'new',
        ]);
    }

    /**
     * Escalate a notification to the next role.
     */
    public function escalate(Notification $notification): void
    {
        $nextRole = config('notifications.escalation.' . $notification->role);

        if ($nextRole) {
            $notification->update([
                'status' => 'escalated',
                'role' => $nextRole,
                'escalated_at' => now(),
            ]);
        }
    }
}
