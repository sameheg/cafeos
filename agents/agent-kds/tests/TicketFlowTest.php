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
        }, 'bar');

        $ticket = [
            'id' => 1,
            'station' => 'bar',
            'items' => [
                ['name' => 'Espresso', 'qty' => 1],
            ],
        ];

        $response = $endpoint->handle($ticket);

        $this->assertSame($ticket, $received, 'Display should receive the ticket');
        $this->assertSame(['status' => 'accepted', 'ticket' => $ticket], $response);
    }

    public function testTicketFilteredByStation(): void
    {
        $service = new KdsService();
        $endpoint = new TicketEndpoint($service);
        $receivedBar = null;
        $receivedGrill = null;
        $service->registerDisplay(function (array $ticket) use (&$receivedBar): void {
            $receivedBar = $ticket;
        }, 'bar');
        $service->registerDisplay(function (array $ticket) use (&$receivedGrill): void {
            $receivedGrill = $ticket;
        }, 'grill');

        $ticket = [
            'id' => 2,
            'station' => 'bar',
            'items' => [
                ['name' => 'Espresso', 'qty' => 1],
            ],
        ];

        $endpoint->handle($ticket);

        $this->assertSame($ticket, $receivedBar);
        $this->assertNull($receivedGrill);
    }

    public function testStationAssignedFromSettings(): void
    {
        $service = new KdsService(['Espresso' => 'bar']);
        $endpoint = new TicketEndpoint($service);
        $received = null;
        $service->registerDisplay(function (array $ticket) use (&$received): void {
            $received = $ticket;
        }, 'bar');

        $ticket = [
            'id' => 3,
            'items' => [
                ['name' => 'Espresso', 'qty' => 1],
            ],
        ];

        $endpoint->handle($ticket);

        $this->assertSame('bar', $received['station']);
    }
}
