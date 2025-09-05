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
    /**
     * @var array<int, array{callback: callable, station: string|null}>
     */
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

    /** @var array<int,Ticket> */
    /** @var array<int,float> */
    private array $startTimes = [];

    public function __construct(private KdsMetrics $metrics)
    {
    }

    /**
     * @var array<int|string, array<string, mixed>> Active tickets indexed by id.
     */
    private array $tickets = [];

    /**
     * Register a display callback that will receive tickets.
     * @param array<string, string> $itemStations Mapping of item names to their stations
     */
    public function __construct(private array $itemStations = [])
    {
    }

    /**
     * Accept a new kitchen ticket and broadcast it.
     *
     * @param array<string,mixed> $ticket
     * @return array<string,mixed>
     * Accept a kitchen ticket, store it as active and broadcast to listeners.
     * Register a display callback that will receive tickets for an optional station.
     */
    public function registerDisplay(callable $listener, ?string $station = null): void
    {
        $this->listeners[] = ['callback' => $listener, 'station' => $station];
    }

    /**
     * Accept a kitchen ticket and broadcast it to the relevant displays.
     *
     * @param array<string, mixed> $ticket
     */
    public function receiveTicket(array $ticket): array
    {
        $model = new Ticket($ticket['id'], $ticket['items']);
        $this->tickets[$model->id] = $model;
        $this->broadcast($model);

        return $model->toArray();
    }

    /**
     * Update the status for an existing ticket and broadcast the change.
     *
     * @return array<string,mixed>|null
     */
    public function updateTicketStatus(int $id, string $status): ?array
    {
        if (!isset($this->tickets[$id])) {
            return null;
        }

        $ticket = $this->tickets[$id];
        $ticket->updateStatus($status);
        // Store metrics if model is available in this runtime
        if (
            class_exists(\App\Models\KdsMetric::class) &&
            method_exists(\App\Models\KdsMetric::class, 'getConnectionResolver') &&
            \App\Models\KdsMetric::getConnectionResolver()
        ) {
            \App\Models\KdsMetric::create([
                'ticket_id' => $ticket['id'] ?? null,
                'prep_time_seconds' => $ticket['prep_time'] ?? null,
                'queue_time_seconds' => $ticket['queue_time'] ?? null,
            ]);
        $id = (int) ($ticket['id'] ?? 0);
        $this->startTimes[$id] = microtime(true);
        $this->metrics->queueAdded();
        $id = $ticket['id'] ?? uniqid('ticket_', true);
        $this->tickets[$id] = $ticket;

        $this->broadcast([
            'type' => 'ticket.created',
            'ticket' => $ticket,
        ]);
    }

    /**
     * Return all currently active tickets.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getActiveTickets(): array
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
        return array_values($this->tickets);
    }

    /**
     * Broadcast a message to all registered displays.
     *
     * @param array<string,mixed> $message
        if (!isset($ticket['station'])) {
            foreach ($ticket['items'] ?? [] as $item) {
                if (isset($this->itemStations[$item['name']])) {
                    $ticket['station'] = $this->itemStations[$item['name']];
                    break;
                }
            }
        }

        $this->broadcast($ticket);

        return $ticket->toArray();
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
     */
    private function broadcast(Ticket $ticket): void
    {
        foreach ($this->listeners as $listener) {
            $listener($ticket->toArray());

     * Broadcast ticket data to all registered displays that match the station.
     *
     * @param array<string, mixed> $ticket
     */
    private function broadcast(array $message): void
    {
        foreach ($this->listeners as $listener) {
            $listener($message);
            if ($listener['station'] === null || ($ticket['station'] ?? null) === $listener['station']) {
                ($listener['callback'])($ticket);
            }
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
