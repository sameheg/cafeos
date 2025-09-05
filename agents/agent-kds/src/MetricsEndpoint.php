<?php
declare(strict_types=1);

/**
 * Exposes collected metrics for scraping by Prometheus or a dashboard.
 */
class MetricsEndpoint
{
    public function __construct(private KdsMetrics $metrics)
    {
    }

    /**
     * Return metrics in text format.
     */
    public function metrics(): string
    {
        return $this->metrics->export();
    }
}
