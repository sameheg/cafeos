<?php

namespace Tests\Contract;

use Modules\Qr\Events\QrOrderPlaced;
use Tests\TestCase;

class QrEventSchemaTest extends TestCase
{
    public function test_event_schema(): void
    {
        $event = new QrOrderPlaced('123', 'table1');
        $payload = $event->toArray();

        $this->assertSame('123', $payload['order_id']);
        $this->assertSame('table1', $payload['table_id']);
    }
}
