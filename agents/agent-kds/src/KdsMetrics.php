<?php
declare(strict_types=1);

/**
 * Collects and exports KDS metrics.
 *
 * Metrics tracked:
 * - Preparation time (seconds) for completed tickets
 * - Current queue length
 *
 * Metrics can be exported in Prometheus exposition format and listeners can
 * subscribe to metric updates for forwarding to a central dashboard.
 */
class KdsMetrics
{
    /** @var int */
    private int $queueLength = 0;

    /** @var float[] */
    private array $preparationTimes = [];

    /** @var callable[] */
    private array $listeners = [];

    /**
     * Increment queue length when a ticket is added.
     */
    public function queueAdded(): void
    {
        $this->queueLength++;
        $this->notify('kds_queue_length', (float) $this->queueLength);
    }

    /**
     * Decrement queue length when a ticket leaves the queue.
     */
    public function queueRemoved(): void
    {
        if ($this->queueLength > 0) {
            $this->queueLength--;
            $this->notify('kds_queue_length', (float) $this->queueLength);
        }
    }

    /**
     * Record preparation time in seconds.
     */
    public function recordPreparation(float $seconds): void
    {
        $this->preparationTimes[] = $seconds;
        $this->notify('kds_preparation_time_seconds', $seconds);
    }

    /**
     * Register a listener to be notified when metrics change.
     *
     * @param callable(string,float):void $listener
     */
    public function registerListener(callable $listener): void
    {
        $this->listeners[] = $listener;
    }

    /**
     * Get current queue length.
     */
    public function getQueueLength(): int
    {
        return $this->queueLength;
    }

    /**
     * Export metrics using Prometheus' text exposition format.
     */
    public function export(): string
    {
        $lines = [];
        $lines[] = '# TYPE kds_queue_length gauge';
        $lines[] = 'kds_queue_length ' . $this->queueLength;
        $lines[] = '# TYPE kds_preparation_time_seconds summary';
        $sum = array_sum($this->preparationTimes);
        $count = count($this->preparationTimes);
        $lines[] = 'kds_preparation_time_seconds_sum ' . $sum;
        $lines[] = 'kds_preparation_time_seconds_count ' . $count;

        return implode("\n", $lines) . "\n";
    }

    /**
     * Notify listeners of metric updates.
     */
    private function notify(string $name, float $value): void
    {
        foreach ($this->listeners as $listener) {
            $listener($name, $value);
        }
    }
}
