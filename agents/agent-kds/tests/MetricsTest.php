<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/KdsMetrics.php';
require_once __DIR__ . '/../src/KdsService.php';
require_once __DIR__ . '/../src/TicketEndpoint.php';
require_once __DIR__ . '/../src/MetricsEndpoint.php';
require_once __DIR__ . '/../src/AuthService.php';
require_once __DIR__ . '/../src/Roles.php';
require_once __DIR__ . '/../src/Ticket.php';

final class MetricsTest extends TestCase
{
    public function testMetricsRecordedAndExported(): void
    {
        $metrics = new KdsMetrics();
        $service = new KdsService($metrics);
        $auth = new AuthService('secret');
        $endpoint = new TicketEndpoint($service, $auth);
        $metricsEndpoint = new MetricsEndpoint($metrics);
        $token = $auth->generateToken(Roles::CHEF);

        $ticket = ['id' => 42];
        $endpoint->handle($ticket, $token);
        $this->assertSame(1, $metrics->getQueueLength());

        usleep(1000); // simulate preparation time
        $endpoint->complete(42);
        $this->assertSame(0, $metrics->getQueueLength());

        $output = $metricsEndpoint->metrics();
        $this->assertStringContainsString('kds_preparation_time_seconds_count 1', $output);
    }

    public function testListenersReceiveEvents(): void
    {
        $metrics = new KdsMetrics();
        $events = [];
        $metrics->registerListener(function (string $name, float $value) use (&$events): void {
            $events[] = [$name, $value];
        });

        $metrics->queueAdded();
        $metrics->recordPreparation(1.5);

        $this->assertSame('kds_queue_length', $events[0][0]);
        $this->assertSame('kds_preparation_time_seconds', $events[1][0]);
        $this->assertSame(1, $metrics->getQueueLength());
    }
}
