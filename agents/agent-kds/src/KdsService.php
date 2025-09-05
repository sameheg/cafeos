<?php
declare(strict_types=1);

/**
 * Simple service to manage kitchen tickets and broadcast them to connected displays.
 */
class KdsService
{
    /** @var callable[] */
    private array $listeners = [];

    /**
     * @var array<int|string, array<string, mixed>> Active tickets indexed by id.
     */
    private array $tickets = [];

    /**
     * Register a display callback that will receive tickets.
     */
    public function registerDisplay(callable $listener): void
    {
        $this->listeners[] = $listener;
    }

    /**
     * Accept a kitchen ticket, store it as active and broadcast to listeners.
     *
     * @param array<string,mixed> $ticket
     */
    public function receiveTicket(array $ticket): void
    {
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
        return array_values($this->tickets);
    }

    /**
     * Broadcast a message to all registered displays.
     *
     * @param array<string,mixed> $message
     */
    private function broadcast(array $message): void
    {
        foreach ($this->listeners as $listener) {
            $listener($message);
        }
    }
}
