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
     * Accept a kitchen ticket and broadcast it.
     *
     * @param array<string,mixed> $ticket
     */
    public function receiveTicket(array $ticket): void
    {
        $this->broadcast($ticket);
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
