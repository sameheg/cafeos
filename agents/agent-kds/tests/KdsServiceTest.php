<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/KdsService.php';
require_once __DIR__ . '/../src/KdsMetrics.php';
require_once __DIR__ . '/../src/Ticket.php';

final class KdsServiceTest extends TestCase
{
    public function testTicketCreationBroadcastsAndIncrementsQueue(): void
    {
        $metrics = new KdsMetrics();
        $service = new KdsService($metrics);
        $messages = [];
        $service->registerDisplay(function (array $payload) use (&$messages): void {
            $messages[] = $payload;
        });

        $ticket = ['id' => 1, 'items' => [['name' => 'Espresso', 'qty' => 1]]];
        $result = $service->receiveTicket($ticket);

        $this->assertSame(1, $metrics->getQueueLength());
        $this->assertSame('kds.ticket.created', $messages[0]['event']);
        $this->assertSame($result, $messages[0]['ticket']);
    }

    public function testStatusUpdateBroadcastsToDisplay(): void
    {
        $metrics = new KdsMetrics();
        $service = new KdsService($metrics);
        $messages = [];
        $service->registerDisplay(function (array $payload) use (&$messages): void {
            $messages[] = $payload;
        });

        $service->receiveTicket(['id' => 2]);
        $service->updateTicketStatus(2, Ticket::STATUS_PREPARING);

        $this->assertSame('kds.ticket.update', $messages[1]['event']);
        $this->assertSame('preparing', $messages[1]['ticket']['status']);
    }

    public function testMetricsLoggedOnTicketCompletion(): void
    {
        $metrics = new KdsMetrics();
        $events = [];
        $metrics->registerListener(function (string $name, float $value) use (&$events): void {
            $events[] = [$name, $value];
        });

        $service = new KdsService($metrics);
        $service->receiveTicket(['id' => 3]);

        usleep(1000);
        $service->completeTicket(3);

        $this->assertSame(0, $metrics->getQueueLength());
        $names = array_column($events, 0);
        $this->assertContains('kds_queue_length', $names);
        $this->assertContains('kds_preparation_time_seconds', $names);
    }
}
