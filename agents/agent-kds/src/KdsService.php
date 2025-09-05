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
     * Register a display callback that will receive tickets.
     */
    public function registerDisplay(callable $listener): void
    {
        $this->listeners[] = $listener;
    }

    /**
     * Accept a kitchen ticket and broadcast it as created.
     *
     * @param array<string,mixed> $ticket
     */
    public function receiveTicket(array $ticket): void
    {
        $payload = [
            'event' => 'kds.ticket.created',
            'ticket' => $ticket,
        ];
        $this->broadcast($payload);
    }

    /**
     * Accept an update to an existing ticket and broadcast it.
     *
     * @param array<string,mixed> $ticket
     */
    public function updateTicket(array $ticket): void
    {
        $payload = [
            'event' => 'kds.ticket.update',
            'ticket' => $ticket,
        ];
        $this->broadcast($payload);
    }

    /**
     * Broadcast ticket data to all registered displays.
     *
     * @param array<string,mixed> $payload
     */
    private function broadcast(array $payload): void
    {
        foreach ($this->listeners as $listener) {
            $listener($payload);
        }
    }
}
