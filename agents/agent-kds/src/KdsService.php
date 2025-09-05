<?php
declare(strict_types=1);

/**
 * Simple service to manage kitchen tickets and broadcast them to connected displays.
 */
class KdsService
{
    /** @var callable[] */
    private array $listeners = [];

    /** @var array<int,float> */
    private array $startTimes = [];

    public function __construct(private KdsMetrics $metrics)
    {
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
        $id = (int) ($ticket['id'] ?? 0);
        $this->startTimes[$id] = microtime(true);
        $this->metrics->queueAdded();

        $this->broadcast($ticket);
    }

    /**
     * Mark a ticket as completed and record metrics.
     */
    public function completeTicket(int $ticketId): void
    {
        if (!isset($this->startTimes[$ticketId])) {
            return;
        }

        $started = $this->startTimes[$ticketId];
        unset($this->startTimes[$ticketId]);
        $this->metrics->queueRemoved();
        $this->metrics->recordPreparation(microtime(true) - $started);
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
}
