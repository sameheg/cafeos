<?php
declare(strict_types=1);

/**
 * Endpoint to receive kitchen tickets and forward them to the service.
 */
class TicketEndpoint
{
    public function __construct(private KdsService $service)
    {
    }

    /**
     * Handle an incoming ticket payload.
     *
     * @param array<string,mixed> $ticket
     * @return array<string,mixed>
     */
    public function handle(array $ticket): array
    {
        $stored = $this->service->receiveTicket($ticket);

        return [
            'status' => 'accepted',
            'ticket' => $stored,
        ];
    }

    /**
     * Update ticket status.
     *
     * @return array<string,mixed>
     */
    public function update(int $id, string $status): array
    {
        $ticket = $this->service->updateTicketStatus($id, $status);

        return [
            'status' => 'updated',
            'ticket' => $ticket,
        ];
    }
}
