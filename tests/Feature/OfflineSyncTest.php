<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Modules\Sync\Services\QueueSyncService;
use Tests\TestCase;

class OfflineSyncTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::forget('offline_sync_queue');
    }

    public function test_successful_requests_are_removed_from_queue(): void
    {
        Http::fake([
            '/foo' => Http::response('', 200),
        ]);

        $service = new QueueSyncService();
        $service->enqueue('/foo', ['a' => 1]);
        $this->assertCount(1, $service->getQueue());

        $service->process();

        $this->assertCount(0, $service->getQueue());
    }

    public function test_failed_requests_remain_in_queue(): void
    {
        Http::fake([
            '/fail' => Http::response('', 500),
        ]);

        $service = new QueueSyncService();
        $service->enqueue('/fail', ['b' => 1]);

        $service->process();

        $this->assertCount(1, $service->getQueue());
    }
}
