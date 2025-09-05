<?php

namespace Modules\Sync\Services;

use Illuminate\Support\Facades\Http;
use Modules\Sync\Entities\SyncQueueItem;

class QueueSyncService
{
    /**
     * Add a request to the offline sync queue.
     */
    public function enqueue(string $url, array $payload, string $method = 'POST'): void
    {
        SyncQueueItem::create([
            'url' => $url,
            'payload' => $payload,
            'method' => $method,
        ]);
    }

    /**
     * Attempt to send queued requests. Successful requests are removed.
     */
    public function process(): void
    {
        $items = SyncQueueItem::all();

        foreach ($items as $item) {
            try {
                Http::send($item->method, $item->url, ['json' => $item->payload]);
                $item->delete();
            } catch (\Exception $e) {
                $item->error_message = $e->getMessage();
                $item->failed_at = now();
                $item->save();
            }
        }
    }

    /**
     * Return current queued requests.
     */
    public function getQueue(): array
    {
        return SyncQueueItem::all()->toArray();
    }
}
