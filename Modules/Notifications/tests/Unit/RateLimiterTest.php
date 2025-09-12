<?php

namespace Modules\Notifications\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Modules\Notifications\Models\NotificationTemplate;
use Modules\Notifications\Services\NotificationSender;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class RateLimiterTest extends TestCase
{
    use RefreshDatabase;

    public function test_rate_limiter_blocks_after_limit(): void
    {
        app()->instance('tenant', (object) ['id' => 't1']);
        $template = NotificationTemplate::create([
            'tenant_id' => 't1',
            'name' => 'tmp',
            'content' => 'Hi',
        ]);

        for ($i = 0; $i < 1000; $i++) {
            RateLimiter::hit('notifications:t1');
        }

        $sender = new NotificationSender;
        $this->expectException(HttpException::class);
        $sender->send($template, ['user@example.com']);
    }
}
