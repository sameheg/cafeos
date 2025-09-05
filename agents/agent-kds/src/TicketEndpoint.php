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

        $this->service->receiveTicket($ticket);

        return [
            'status' => 'accepted',
            'ticket' => $ticket,
        ];
    }
}

