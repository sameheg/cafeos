<?php

namespace Modules\Core\Application\Health;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class HealthStatusQuery
{
    public function handle(): array
    {
        $status = $this->overallStatus();

        return [
            'status' => $status,
            'message' => $status === 'ok' ? __('core::health.ok') : 'ERROR',
            'checks' => [
                'database' => $this->checkDatabase(),
                'cache' => $this->checkCache(),
                'queue' => $this->checkQueue(),
            ],
        ];
    }

    protected function overallStatus(): string
    {
        return ($this->checkDatabase() && $this->checkCache() && $this->checkQueue()) ? 'ok' : 'error';
    }

    protected function checkDatabase(): bool
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected function checkCache(): bool
    {
        try {
            Cache::set('__health_check', 'ok', 1);

            return Cache::get('__health_check') === 'ok';
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected function checkQueue(): bool
    {
        try {
            Queue::size();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
