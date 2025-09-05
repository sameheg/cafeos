<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

require_once __DIR__ . '/../src/KdsService.php';

final class MonitoringTest extends TestCase
{
    public function test_queue_length_alert_is_triggered(): void
    {
        $alerts = [];
        $logger = new class implements LoggerInterface {
            public array $warnings = [];
            public function emergency($message, array $context = []): void {}
            public function alert($message, array $context = []): void {}
            public function critical($message, array $context = []): void {}
            public function error($message, array $context = []): void {}
            public function warning($message, array $context = []): void { $this->warnings[] = $message; }
            public function notice($message, array $context = []): void {}
            public function info($message, array $context = []): void {}
            public function debug($message, array $context = []): void {}
            public function log($level, $message, array $context = []): void {}
        };
        $notifier = function (string $msg) use (&$alerts): void {
            $alerts[] = $msg;
        };
        $service = new KdsService(1, 1000, $logger, $notifier);

        $service->receiveTicket(['id' => 1]);
        $this->assertCount(0, $alerts, 'No alert expected for first ticket');
        $service->receiveTicket(['id' => 2]);
        $this->assertCount(1, $alerts, 'Alert expected when queue threshold exceeded');
        $this->assertCount(1, $logger->warnings, 'Alert should be logged');
    }

    public function test_ticket_time_alert_is_triggered(): void
    {
        $alerts = [];
        $logger = new class implements LoggerInterface {
            public array $warnings = [];
            public function emergency($message, array $context = []): void {}
            public function alert($message, array $context = []): void {}
            public function critical($message, array $context = []): void {}
            public function error($message, array $context = []): void {}
            public function warning($message, array $context = []): void { $this->warnings[] = $message; }
            public function notice($message, array $context = []): void {}
            public function info($message, array $context = []): void {}
            public function debug($message, array $context = []): void {}
            public function log($level, $message, array $context = []): void {}
        };
        $notifier = function (string $msg) use (&$alerts): void {
            $alerts[] = $msg;
        };
        $service = new KdsService(10, 0, $logger, $notifier);

        $service->receiveTicket(['id' => 1]);
        $this->assertCount(1, $alerts, 'Alert expected when ticket time threshold exceeded');
        $this->assertCount(1, $logger->warnings, 'Alert should be logged');
    }
}
