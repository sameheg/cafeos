<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/KdsService.php';
require_once __DIR__ . '/../src/OrderEventConsumer.php';

final class OrderEventConsumerTest extends TestCase
{
    public function testTransformsCreatedEventToTicket(): void
    {
        $service = new KdsService();
        $consumer = new OrderEventConsumer($service);
        $received = null;
        $service->registerDisplay(function (array $ticket) use (&$received): void {
            $received = $ticket;
        });

        $event = [
            'type' => 'pos.order.created',
            'data' => ['id' => 10, 'table_id' => 5],
        ];

        $consumer->handle($event);

        $this->assertSame(['id' => 10, 'table_id' => 5, 'status' => 'new'], $received);
    }

    public function testTransformsCompletedEventToTicket(): void
    {
        $service = new KdsService();
        $consumer = new OrderEventConsumer($service);
        $received = null;
        $service->registerDisplay(function (array $ticket) use (&$received): void {
            $received = $ticket;
        });

        $event = [
            'type' => 'pos.order.completed',
            'data' => ['id' => 11, 'table_id' => 6],
        ];

        $consumer->handle($event);

        $this->assertSame(['id' => 11, 'table_id' => 6, 'status' => 'completed'], $received);
    }

    public function testIgnoresUnknownEvent(): void
    {
        $service = new KdsService();
        $consumer = new OrderEventConsumer($service);
        $called = false;
        $service->registerDisplay(function () use (&$called): void {
            $called = true;
        });

        $consumer->handle(['type' => 'something-else']);

        $this->assertFalse($called);
    }
}
