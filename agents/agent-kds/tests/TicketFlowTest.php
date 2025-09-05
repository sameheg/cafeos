<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Ticket.php';
require_once __DIR__ . '/../src/KdsService.php';
require_once __DIR__ . '/../src/TicketEndpoint.php';

final class TicketFlowTest extends TestCase
{
    public function testTicketStatusFlowAndBroadcast(): void
    {
        $service = new KdsService();
        $endpoint = new TicketEndpoint($service);
        $received = [];
        $service->registerDisplay(function (array $ticket) use (&$received): void {
            $received[] = $ticket;
        });

        $ticket = [
            'id' => 1,
            'items' => [
                ['name' => 'Espresso', 'qty' => 1],
            ],
        ];

        $response = $endpoint->handle($ticket);
        $this->assertSame('accepted', $response['status']);
        $this->assertSame('pending', $received[0]['status']);
        $this->assertArrayHasKey('pending', $received[0]['timestamps']);

        $endpoint->update(1, Ticket::STATUS_PREPARING);
        $this->assertSame('preparing', $received[1]['status']);
        $this->assertArrayHasKey('preparing', $received[1]['timestamps']);

        $endpoint->update(1, Ticket::STATUS_READY);
        $this->assertSame('ready', $received[2]['status']);
        $this->assertNotNull($received[2]['preparation_time']);

        $endpoint->update(1, Ticket::STATUS_SERVED);
        $this->assertSame('served', $received[3]['status']);
        $this->assertArrayHasKey('served', $received[3]['timestamps']);
    }
}
