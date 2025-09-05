<?php
declare(strict_types=1);

/**
 * Simple service to manage kitchen tickets and broadcast them to connected displays.
 */
class KdsService
{
    /** @var callable[] */
    private array $listeners = [];

    /** @var array<int,Ticket> */
    private array $tickets = [];

    /**
     * Register a display callback that will receive tickets.
     */
    public function registerDisplay(callable $listener): void
    {
        $this->listeners[] = $listener;
    }

    /**
     * Accept a new kitchen ticket and broadcast it.
     *
     * @param array<string,mixed> $ticket
     * @return array<string,mixed>
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
        $this->broadcast($ticket);

        return $ticket->toArray();
    }

    /**
     * Broadcast ticket data to all registered displays.
     */
    private function broadcast(Ticket $ticket): void
    {
        foreach ($this->listeners as $listener) {
            $listener($ticket->toArray());
        }
    }
}
