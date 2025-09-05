<?php
declare(strict_types=1);

/**
 * Minimal HTTP + WebSocket server facade for the KDS agent.
 *
 * This class does not open network sockets itself; instead it exposes
 * methods that can be wired into any HTTP/WebSocket implementation.
 */
class KdsServer
{
    public function __construct(private KdsService $service)
    {
        // Bridge service broadcasts to connected WebSocket clients.
        $this->service->registerDisplay(function (array $message): void {
            $this->broadcast($message);
        });
    }

    /** @var callable[] */
    private array $wsClients = [];

    /**
     * Handle an HTTP-like request.
     *
     * @param array<string,mixed>|null $payload
     * @return array<string,mixed>
     */
    public function handleRequest(string $method, string $path, ?array $payload = null): array
    {
        if ($method === 'POST' && $path === '/tickets') {
            $ticket = $payload ?? [];
            $this->service->receiveTicket($ticket);

            return [
                'status' => 201,
                'body' => [
                    'status' => 'accepted',
                    'ticket' => $ticket,
                ],
            ];
        }

        if ($method === 'GET' && $path === '/tickets/active') {
            return [
                'status' => 200,
                'body' => [
                    'tickets' => $this->service->getActiveTickets(),
                ],
            ];
        }

        return ['status' => 404];
    }

    /**
     * Register a WebSocket client.
     *
     * @param callable $sender Callback that receives string messages for the client.
     */
    public function connectWebSocket(callable $sender): void
    {
        $this->wsClients[] = $sender;
        // Send initial state
        $sender(json_encode([
            'type' => 'tickets.active',
            'tickets' => $this->service->getActiveTickets(),
        ]));
    }

    /**
     * Broadcast a message to all connected WebSocket clients.
     *
     * @param array<string,mixed> $message
     */
    private function broadcast(array $message): void
    {
        $encoded = json_encode($message);
        foreach ($this->wsClients as $sender) {
            $sender($encoded);
        }
    }
}
