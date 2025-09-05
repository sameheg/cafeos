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
    }
}
