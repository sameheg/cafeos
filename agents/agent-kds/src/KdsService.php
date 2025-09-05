<?php
declare(strict_types=1);

/**
 * Service to manage kitchen tickets and broadcast changes to displays.
 */
class KdsService
{
    /**
     * @var array<int,array{callback: callable, station: string|null}>
     */
    private array $listeners = [];

    /** @var array<int, Ticket> */
    private array $tickets = [];

    /** @var array<int, float> */
    private array $startTimes = [];

    /** @var array<int, string|null> */
    private array $ticketStations = [];

    /**
     * @param array<string,string> $itemStations Mapping of item names to stations.
     */
    public function __construct(
        private KdsMetrics $metrics,
        private array $itemStations = []
    ) {
    }

    /**
     * Register a display callback for an optional station.
     */
    public function registerDisplay(callable $listener, ?string $station = null): void
    {
        $this->listeners[] = ['callback' => $listener, 'station' => $station];
    }

    /**
     * Accept a new kitchen ticket and broadcast it.
     *
     * @param array<string,mixed> $ticket
     * @return array<string,mixed>
     */
    public function receiveTicket(array $ticket): array
    {
        $model = new Ticket($ticket['id'], $ticket['items'] ?? []);
        $this->tickets[$model->id] = $model;
        $this->startTimes[$model->id] = microtime(true);

        $station = $ticket['station'] ?? $this->detectStation($ticket['items'] ?? []);
        $this->ticketStations[$model->id] = $station;

        $this->metrics->queueAdded();

        $payloadTicket = $model->toArray();
        if ($station !== null) {
            $payloadTicket['station'] = $station;
        }

        $this->broadcast([
            'event' => 'kds.ticket.created',
            'ticket' => $payloadTicket,
        ], $station);

        return $payloadTicket;
    }

    /**
     * Update an existing ticket and broadcast the change.
     *
     * @param array{id:int, status?:string} $ticket
     * @return array<string,mixed>|null
     */
    public function updateTicket(array $ticket): ?array
    {
        $id = $ticket['id'] ?? null;
        if ($id === null || !isset($this->tickets[$id])) {
            return null;
        }

        $model = $this->tickets[$id];
        if (isset($ticket['status'])) {
            $model->updateStatus($ticket['status']);
        }

        $payloadTicket = $model->toArray();
        $station = $this->ticketStations[$id] ?? null;
        if ($station !== null) {
            $payloadTicket['station'] = $station;
        }

        $this->broadcast([
            'event' => 'kds.ticket.update',
            'ticket' => $payloadTicket,
        ], $station);

        return $payloadTicket;
    }

    public function updateTicketStatus(int $id, string $status): ?array
    {
        return $this->updateTicket(['id' => $id, 'status' => $status]);
    }

    /**
     * Mark a ticket as completed and record metrics.
     */
    public function completeTicket(int $id): void
    {
        if (!isset($this->tickets[$id])) {
            return;
        }

        $ticket = $this->tickets[$id];
        $ticket->updateStatus(Ticket::STATUS_READY);
        unset($this->tickets[$id]);

        $station = $this->ticketStations[$id] ?? null;
        unset($this->ticketStations[$id]);

        if (isset($this->startTimes[$id])) {
            $started = $this->startTimes[$id];
            unset($this->startTimes[$id]);
            $this->metrics->queueRemoved();
            $this->metrics->recordPreparation(microtime(true) - $started);
        } else {
            $this->metrics->queueRemoved();
        }

        $payloadTicket = $ticket->toArray();
        if ($station !== null) {
            $payloadTicket['station'] = $station;
        }

        $this->broadcast([
            'event' => 'kds.ticket.update',
            'ticket' => $payloadTicket,
        ], $station);
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public function getActiveTickets(): array
    {
        return array_map(
            static fn (Ticket $t): array => $t->toArray(),
            array_values($this->tickets)
        );
    }

    /**
     * Determine station for a list of items.
     *
     * @param array<int,array<string,mixed>> $items
     */
    private function detectStation(array $items): ?string
    {
        foreach ($items as $item) {
            $name = $item['name'] ?? null;
            if ($name !== null && isset($this->itemStations[$name])) {
                return $this->itemStations[$name];
            }
        }

        return null;
    }

    /**
     * Broadcast message to registered displays.
     *
     * @param array<string,mixed> $message
     */
    private function broadcast(array $message, ?string $station = null): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener['station'] === null || $listener['station'] === $station) {
                $listener['callback']($message);
            }
        }
    }
}
