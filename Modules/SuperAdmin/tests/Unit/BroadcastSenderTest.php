<?php

namespace Modules\SuperAdmin\Tests\Unit;

use Illuminate\Support\Facades\Queue;
use Modules\SuperAdmin\Jobs\BroadcastMessageJob;
use Modules\SuperAdmin\Tests\TestCase;

class BroadcastSenderTest extends TestCase
{

    public function test_job_dispatched(): void
    {
        Queue::fake();
        BroadcastMessageJob::dispatch('hello');
        Queue::assertPushed(BroadcastMessageJob::class);
    }
}
