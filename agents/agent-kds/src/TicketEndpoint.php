<?php
declare(strict_types=1);

/**
 * Endpoint to receive kitchen tickets and forward them to the service.
 */
class TicketEndpoint
{
    public function __construct(private KdsService $service, private AuthService $auth)
    {
    }

    /**
     * Handle an incoming ticket payload.
     *
     * @param array<string,mixed> $ticket
     * @return array<string,mixed>
     */
    public function handle(array $ticket, string $token): array
    {
        if (! $this->auth->validate($token, [Roles::CHEF, Roles::KITCHEN_MANAGER])) {
            throw new RuntimeException('Unauthorized');
        }

        if (! array_key_exists('station', $ticket)) {
            $ticket['station'] = null;
        }

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

