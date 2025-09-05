<?php
declare(strict_types=1);

/**
 * Simple service to manage kitchen tickets and broadcast them to connected displays.
 */
class KdsService
{
    /**
     * @var array<int, array{callback: callable, station: string|null}>
     */
    private array $listeners = [];

    /**
     * @param array<string, string> $itemStations Mapping of item names to their stations
     */
    public function __construct(private array $itemStations = [])
    {
    }

    /**
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
    public function receiveTicket(array $ticket): void
    {
        if (!isset($ticket['station'])) {
            foreach ($ticket['items'] ?? [] as $item) {
                if (isset($this->itemStations[$item['name']])) {
                    $ticket['station'] = $this->itemStations[$item['name']];
                    break;
                }
            }
        }

        $this->broadcast($ticket);
    }

    /**
     * Broadcast ticket data to all registered displays that match the station.
     *
     * @param array<string, mixed> $ticket
     */
    private function broadcast(array $ticket): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener['station'] === null || ($ticket['station'] ?? null) === $listener['station']) {
                ($listener['callback'])($ticket);
            }
        }
    }
}
