<?php

namespace Modules\Notifications\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelFallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_channel_fallback_to_mail(): void
    {
        $this->markTestSkipped('Requires mail/SMS drivers to simulate failures.');
    }
}
