<?php
declare(strict_types=1);

/**
 * Endpoint to receive kitchen ticket updates and forward them to the service.
 */
class TicketUpdateEndpoint
{
    public function __construct(private KdsService $service)
    {
    }

    /**
     * Handle an incoming ticket update payload.
     *
     * @param array<string,mixed> $ticket
     * @return array<string,mixed>
     */
    public function handle(array $ticket): array
    {
        $this->service->updateTicket($ticket);

        return [
            'status' => 'accepted',
            'ticket' => $ticket,
        ];
    }
}
