<?php

namespace Modules\Notifications\Services;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Modules\Notifications\Jobs\SendNotificationChunk;
use Modules\Notifications\Models\NotificationTemplate;

class NotificationSender
{
    /**
     * Dispatch chunked notification jobs respecting rate limits.
     */
    public function send(NotificationTemplate $template, array $recipients, string $channel = 'mail', ?string $fallback = 'twilio'): string
    {
        $tenantId = app()->bound('tenant') ? app('tenant')->id : null;
        $rateKey = "notifications:{$tenantId}";
        if (RateLimiter::tooManyAttempts($rateKey, 1000)) {
            abort(429, 'Rate limit exceeded');
        }
        RateLimiter::hit($rateKey, now()->addDay()->diffInSeconds());

        $notifId = (string) Str::ulid();
        $chunks = array_chunk($recipients, config('notifications.chunk_size', 50));
        foreach ($chunks as $chunk) {
            SendNotificationChunk::dispatch($notifId, $template->id, $chunk, $channel, $fallback);
        }

        return $notifId;
    }

    /**
     * Send notification to a single recipient with optional fallback.
     */
    public function sendToRecipient(NotificationTemplate $template, string $recipient, string $channel, ?string $fallback, string $notifId): void
    {
        $tenantId = app()->bound('tenant') ? app('tenant')->id : null;

        $log = \Modules\Notifications\Models\NotificationLog::create([
            'tenant_id' => $tenantId,
            'channel' => $channel,
            'status' => 'queued',
        ]);

        try {
            $notification = new \Modules\Notifications\Notifications\GenericNotification($template->content, $channel);
            \Illuminate\Support\Facades\Notification::route($channel, $recipient)->notify($notification);

            $log->update(['status' => 'sent', 'sent_at' => now()]);

            \Modules\Core\Support\EventBus::emit('notifications.sent@v1', [
                'notif_id' => $log->id,
                'channel' => $channel,
                'tenant_id' => $tenantId,
            ]);
        } catch (\Throwable $e) {
            $log->update(['status' => 'failed']);
            if ($fallback && \Laravel\Pennant\Feature::active('notifications_fallback')) {
                $this->sendToRecipient($template, $recipient, $fallback, null, $notifId);
            }
        }
    }
}
