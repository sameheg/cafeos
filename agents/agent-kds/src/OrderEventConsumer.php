<?php
declare(strict_types=1);

/**
 * Consume POS order events and forward them as kitchen tickets.
 */
class OrderEventConsumer
{
    public function __construct(private KdsService $service)
    {
    }

    /**
     * Handle a POS order event.
     *
     * @param array<string,mixed> $event
     */
    public function handle(array $event): void
    {
        $type = $event['type'] ?? '';
        if (! in_array($type, ['pos.order.created', 'pos.order.completed'], true)) {
            return;
        }

        $data = $event['data'] ?? [];
        $ticket = [
            'id' => $data['id'] ?? null,
            'table_id' => $data['table_id'] ?? null,
            'status' => $type === 'pos.order.completed' ? 'completed' : 'new',
        ];

        $this->service->receiveTicket($ticket);
    }
}
