<?php

namespace Modules\ArMenu\Tests\Contract;

use Modules\ArMenu\Events\ArMenuViewed;
use Tests\TestCase;

class ArEventSchemaTest extends TestCase
{
    public function test_event_payload_schema(): void
    {
        $event = new ArMenuViewed('123', 'ar');
        $payload = $event->toPayload();
        $this->assertSame('ar.menu.viewed@v1', $payload['event']);
        $this->assertEquals('123', $payload['data']['item_id']);
        $this->assertEquals('ar', $payload['data']['mode']);
    }
}
