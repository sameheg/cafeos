<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/KdsService.php';
require_once __DIR__ . '/../src/TicketEndpoint.php';

final class TicketFlowTest extends TestCase
{
    public function testTicketBroadcastToDisplay(): void
    {
        $service = new KdsService();
        $endpoint = new TicketEndpoint($service);
        $received = null;
        $service->registerDisplay(function (array $payload) use (&$received): void {
            $received = $payload;
        });

        $ticket = [
            'id' => 1,
            'items' => [
                ['name' => 'Espresso', 'qty' => 1],
            ],
        ];

        $response = $endpoint->handle($ticket);

        $expectedPayload = [
            'event' => 'kds.ticket.created',
            'ticket' => $ticket,
        ];

        $this->assertSame($expectedPayload, $received, 'Display should receive the ticket');
        $this->assertSame(['status' => 'accepted', 'ticket' => $ticket], $response);
    }
}
