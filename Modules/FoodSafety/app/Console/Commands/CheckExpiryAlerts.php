<?php

namespace Modules\FoodSafety\Console\Commands;

use Illuminate\Console\Command;
use Modules\FoodSafety\Services\FoodSafetyService;

class CheckExpiryAlerts extends Command
{
    protected $signature = 'foodsafety:check-expiry {--days=3}';

    protected $description = 'Dispatch alerts for ingredients nearing expiration';

    public function handle(FoodSafetyService $service): int
    {
        $service->checkExpirations((int) $this->option('days'));
        $this->info('Expiry check completed.');

        return self::SUCCESS;
    }
}
