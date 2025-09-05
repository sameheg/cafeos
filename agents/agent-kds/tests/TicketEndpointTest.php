<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/KdsService.php';
require_once __DIR__ . '/../src/TicketEndpoint.php';

final class TicketEndpointTest extends TestCase
{
    public function testHandleReturnsAcceptedResponse(): void
    {
        $service = new KdsService();
        $endpoint = new TicketEndpoint($service);
        $ticket = ['id' => 5, 'items' => [['name' => 'Americano', 'qty' => 1]]];

        $response = $endpoint->handle($ticket);

        $this->assertSame('accepted', $response['status']);
        $this->assertSame($ticket, $response['ticket']);
    }

    public function testHandlePropagatesServiceExceptions(): void
    {
        $service = $this->createMock(KdsService::class);
        $service->expects($this->once())
            ->method('receiveTicket')
            ->willThrowException(new RuntimeException('failure'));

        $endpoint = new TicketEndpoint($service);
        $ticket = ['id' => 6, 'items' => [['name' => 'Cappuccino', 'qty' => 1]]];

        $this->expectException(RuntimeException::class);
        $endpoint->handle($ticket);
    }
}
