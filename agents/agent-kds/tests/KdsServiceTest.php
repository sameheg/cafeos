<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/KdsService.php';

class KdsServiceTest extends TestCase
{
    public function testUpdateTicketBroadcastsEvent(): void
    {
        $service = new KdsService();
        $received = null;
        $service->registerDisplay(function ($payload) use (&$received) {
            $received = $payload;
        });

        $service->updateTicket(['id' => 5]);

        $this->assertIsArray($received);
        $this->assertSame('kds.ticket.update', $received['event']);
        $this->assertSame(5, $received['ticket']['id']);
final class KdsServiceTest extends TestCase
{
    public function testBroadcastsToAllRegisteredDisplays(): void
    {
        $service = new KdsService();
        $received = [];
        $service->registerDisplay(function (array $ticket) use (&$received): void {
            $received[] = ['display1' => $ticket];
        });
        $service->registerDisplay(function (array $ticket) use (&$received): void {
            $received[] = ['display2' => $ticket];
        });

        $ticket = ['id' => 99, 'items' => [['name' => 'Latte', 'qty' => 2]]];
        $service->receiveTicket($ticket);

        $this->assertCount(2, $received);
        $this->assertSame($ticket, $received[0]['display1']);
        $this->assertSame($ticket, $received[1]['display2']);
    }

    public function testBroadcastWithNoDisplaysDoesNotError(): void
    {
        $service = new KdsService();
        $ticket = ['id' => 100, 'items' => [['name' => 'Mocha', 'qty' => 1]]];

        $service->receiveTicket($ticket);

        // No assertions needed; absence of exception indicates pass.
        $this->assertTrue(true);
    }
}
