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
        if (!array_key_exists('station', $ticket)) {
            $ticket['station'] = null;
        }

        $this->service->receiveTicket($ticket);

        return [
            'status' => 'accepted',
            'ticket' => $ticket,
        ];
    }

    /**
     * Mark a ticket as completed.
     */
    public function complete(int $ticketId): array
    {
        $this->service->completeTicket($ticketId);

        return [
            'status' => 'completed',
            'id' => $ticketId,
        ];
    }
}
