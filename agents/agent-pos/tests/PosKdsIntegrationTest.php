<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../agent-kds/src/KdsService.php';
require_once __DIR__ . '/../../agent-kds/src/TicketEndpoint.php';

class Metrics
{
    public int $successful = 0;
    public int $failed = 0;

    public function incrementSuccess(): void
    {
        $this->successful++;
    }

    public function incrementFailure(): void
    {
        $this->failed++;
    }
}

class MetricsKdsService extends KdsService
{
    public function __construct(private Metrics $metrics, private bool $shouldFail = false)
    {
    }

    public function receiveTicket(array $ticket): void
    {
        if ($this->shouldFail) {
            $this->metrics->incrementFailure();
            throw new RuntimeException('POS error');
        }

        $this->metrics->incrementSuccess();
        parent::receiveTicket($ticket);
    }
}

final class PosKdsIntegrationTest extends TestCase
{
    public function testMetricsAreRecordedForSuccessAndFailure(): void
    {
        $ticket = ['id' => 42, 'items' => [['name' => 'Flat White', 'qty' => 1]]];

        // Successful ticket processing
        $metrics = new Metrics();
        $service = new MetricsKdsService($metrics);
        $endpoint = new TicketEndpoint($service);
        $service->registerDisplay(fn (array $t) => null);
        $endpoint->handle($ticket);

        $this->assertSame(1, $metrics->successful);
        $this->assertSame(0, $metrics->failed);

        // Failed ticket processing
        $metricsFail = new Metrics();
        $serviceFail = new MetricsKdsService($metricsFail, true);
        $endpointFail = new TicketEndpoint($serviceFail);
        try {
            $endpointFail->handle($ticket);
        } catch (RuntimeException $e) {
            // expected
        }

        $this->assertSame(0, $metricsFail->successful);
        $this->assertSame(1, $metricsFail->failed);
    }
}
