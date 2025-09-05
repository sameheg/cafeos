<?php

namespace Modules\Sync\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class QueueSyncService
{
    protected string $cacheKey = 'offline_sync_queue';

    /**
     * Add a request to the offline sync queue.
     */
    public function enqueue(string $url, array $payload, string $method = 'POST'): void
    {
        $queue = Cache::get($this->cacheKey, []);
        $queue[] = [
            'url' => $url,
            'payload' => $payload,
            'method' => $method,
        ];
        Cache::put($this->cacheKey, $queue);
    }

    /**
     * Attempt to send queued requests. Successful requests are removed.
     */
    public function process(): void
    {
        $queue = Cache::get($this->cacheKey, []);
        $remaining = [];

        foreach ($queue as $item) {
            try {
                Http::send($item['method'], $item['url'], ['json' => $item['payload']]);
            } catch (\Exception $e) {
                $remaining[] = $item;
                continue;
            }
        }

        Cache::put($this->cacheKey, $remaining);
    }

    /**
     * Return current queued requests.
     */
    public function getQueue(): array
    {
        return Cache::get($this->cacheKey, []);
    }
}
