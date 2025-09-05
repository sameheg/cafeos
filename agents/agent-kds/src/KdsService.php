<?php
declare(strict_types=1);

/**
 * Simple service to manage kitchen tickets and broadcast them to connected displays.
 */
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Simple service to manage kitchen tickets and broadcast them to connected displays.
 * It also monitors queue length and ticket wait times to raise alerts.
 */
class KdsService
{
    /** @var callable[] */
    private array $listeners = [];

    /** @var array<string,array<string,mixed>> */
    private array $queue = [];

    /** @var callable */
    private $notifier;

    public function __construct(
        private int $queueThreshold = 10,
        private int $ticketTimeThreshold = 300,
        private LoggerInterface $logger = new NullLogger(),
        ?callable $notifier = null,
    ) {
        $this->notifier = $notifier ?? static function (string $message): void {
        };
    }

    /**
     * Register a display callback that will receive tickets.
     */
    public function registerDisplay(callable $listener): void
    {
        $this->listeners[] = $listener;
    }

    /**
     * Accept a kitchen ticket and broadcast it.
     *
     * @param array<string,mixed> $ticket
     */
    public function receiveTicket(array $ticket): void
    {
        $ticket['received_at'] = microtime(true);
        $this->queue[(string) ($ticket['id'] ?? uniqid())] = $ticket;
        $this->broadcast($ticket);
        $this->monitor();
    }

    /**
     * Mark a ticket as completed and re-evaluate thresholds.
     */
    public function markDone(string|int $ticketId): void
    {
        unset($this->queue[(string) $ticketId]);
        $this->monitor();
    }

    /**
     * Broadcast ticket data to all registered displays.
     *
     * @param array<string,mixed> $ticket
     */
    private function broadcast(array $ticket): void
    {
        foreach ($this->listeners as $listener) {
            $listener($ticket);
        }
    }

    /**
     * Check current queue state and raise alerts when thresholds are exceeded.
     */
    private function monitor(): void
    {
        $now = microtime(true);
        $queueLength = count($this->queue);
        $exceeded = [];
        foreach ($this->queue as $ticket) {
            if (($now - (float) $ticket['received_at']) > $this->ticketTimeThreshold) {
                $exceeded[] = $ticket['id'] ?? 'unknown';
            }
        }

        if ($queueLength > $this->queueThreshold || $exceeded !== []) {
            $msg = sprintf(
                'KDS alert: queue_length=%d exceeded=%s',
                $queueLength,
                $exceeded === [] ? 'none' : implode(',', $exceeded),
            );
            ($this->notifier)($msg);
            $this->logger->warning($msg);
        }
    }
}
