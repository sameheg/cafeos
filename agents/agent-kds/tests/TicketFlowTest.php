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
        $service->registerDisplay(function (array $ticket) use (&$received): void {
            $received = $ticket;
        });

        $ticket = [
            'id' => 1,
            'items' => [
                ['name' => 'Espresso', 'qty' => 1],
            ],
        ];

        $response = $endpoint->handle($ticket);

        $this->assertSame($ticket, $received, 'Display should receive the ticket');
        $this->assertSame(['status' => 'accepted', 'ticket' => $ticket], $response);
    }
}
