<?php
declare(strict_types=1);

/**
 * Domain model representing a kitchen ticket with state transitions
 * and timestamps for each state.
 */
class Ticket
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_READY = 'ready';
    public const STATUS_SERVED = 'served';

    private string $status;

    /** @var array<string,int> */
    private array $timestamps = [];

    /**
     * @param array<int, array<string, mixed>> $items
     */
    public function __construct(public int $id, public array $items)
    {
        $this->status = self::STATUS_PENDING;
        $this->timestamps[self::STATUS_PENDING] = $this->now();
    }

    public function updateStatus(string $status): void
    {
        $this->status = $status;
        $this->timestamps[$status] = $this->now();
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array<string,int>
     */
    public function getTimestamps(): array
    {
        return $this->timestamps;
    }

    public function getPreparationTime(): ?int
    {
        if (isset($this->timestamps[self::STATUS_PREPARING], $this->timestamps[self::STATUS_READY])) {
            return $this->timestamps[self::STATUS_READY] - $this->timestamps[self::STATUS_PREPARING];
        }
        return null;
    }

    /**
     * Represent ticket as array for broadcasting.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'items' => $this->items,
            'status' => $this->status,
            'timestamps' => $this->timestamps,
            'preparation_time' => $this->getPreparationTime(),
        ];
    }

    private function now(): int
    {
        return time();
    }
}
